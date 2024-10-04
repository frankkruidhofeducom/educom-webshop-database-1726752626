<?php
require_once 'config.php';

function connectDatabase() //connect to database 
{
    // establish connection
    $conn = new mysqli(SERVER_NAME, DB_USERNAME, DB_PASS, DB_NAME);
    // check connection 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . "<br>Er kan op dit moment geen verbinding gemaakt worden met het gebruikersbestand");
    }

    return $conn;
}

function createNewUser(string $name, string $email, string $password) // insert new user record into database
{
    $conn = connectDatabase();

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    $stmt->execute();

    if ($stmt->errno != 0) {
        echo "Er ging iets fout... " . $stmt->error;
    }
    $stmt->close();

    $conn->close();
}


function getUserByEmail(string $email): ?array // find user in users table by email adress, returns array
{
    // prepare statement
    $conn = connectDatabase();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);

    // set parameters & execute statement 
    $stmt->execute();
    $foundUsers = $stmt->get_result()->fetch_assoc();

    // close statement
    $stmt->close();
    $conn->close();
    // return array
    return $foundUsers;
}

function getProductbyArticleId($articleId)
{
       // prepare statement
       $conn = connectDatabase();
       $stmt = $conn->prepare("SELECT * FROM products WHERE article_id=?");
       $stmt->bind_param("s", $articleId);
   
       // set parameters & execute statement 
       $stmt->execute();
       $product = $stmt->get_result()->fetch_assoc();
   
       // close statement
       $stmt->close();
       $conn->close();
       // return array
       return $product;
}

function selectFromProductsByProductId($productId)
{
       // prepare statement
       $conn = connectDatabase();
       $stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
       $stmt->bind_param("i", $productId);
   
       // set parameters & execute statement 
       $stmt->execute();
       $product = $stmt->get_result()->fetch_assoc();
   
       // close statement
       $stmt->close();
       $conn->close();
       // return array
       return $product;
}

function createSelectSqlStatement(string $tableName, array $column): string
{
    $sql = "";
    $get = "";
    
    $get = implode(", ", $column);
    $sql .= "SELECT ";
    $sql .= $get;
    $sql .= " FROM " . $tableName . " ";

    return $sql;
}

function getAllRows(string $tableName, array $column):array //returns associative array
{   
    //get database connection
    $conn = connectDatabase();
    // prepare statement
    $sql = createSelectSqlStatement($tableName, $column);
    $stmt = $conn->prepare($sql);
    // execute statement
    $stmt->execute();
    // get results from query
    $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    // end statements
    $stmt->close();
    return $products;
}

function insertNewCart() //creates new row in table with no user_id
{
     $conn = connectDatabase();

     $stmt = $conn->prepare("INSERT INTO shoppingcarts (id) VALUE ('0')"); 

     if ($stmt->execute() === TRUE) {
        $lastId = $conn->insert_id;
        $stmt->close();
        $conn->close();
        return $lastId;
     } else {
        echo "Sorry, er kon helaas geen winkelmandje gemaakt worden...";
        $stmt->close();
        $conn->close();
     }
}

function saveCartToUser() // assign user_id to cart
{
    // if user is not logged in and has a cart in the session, they should be able to save the session cart to their account
    // if user registers, they should get a cart assigned to their account
    // if user logs in, the account's cart should load
    // when they pay, a new empty cart should be assigned to their account
} 

function getCartIdFromSession():string
{
    if (isset($_SESSION['cartId'])) {
        $cartId = $_SESSION['cartId'];
        return $cartId;
    }
}

function getCartIdFromUser()
{
    $userId = $_SESSION['userId'];
    $conn = connectDatabase();
    $stmt = $conn->prepare("SELECT id FROM shoppingcarts WHERE user_id=?");
    $stmt->bind_param("i", $userId);

    $stmt->execute();
    $cartRow = $stmt->get_result()->fetch_assoc();
    $cartId = $cartRow['id'];

    $stmt->close();
    $conn->close();

    return $cartId;
}

function getCartId()
{
    if (isUserLoggedIn()) {
        $cartId = getCartIdFromUser($_SESSION['userId']);
        return $cartId;
    } else {
        $cartId = getCartIdFromSession($_SESSION['cartId']);
        return $cartId; //kan ook simpeler, dat $_SESSION['cartId'] overschreven wordt als user inlogt, en er gewoon altijd naar $_SESSION['cartId'] gevraagd kan worden
    }
}

function insertNewCartItem($cartId, $productId):int
{
    $conn = connectDatabase();
    if (isItemInCart($cartId, $productId)){ 
        $quantity = increaseItemQuantityByOne($cartId, $productId); 
        echo 'Product is found in cart and this is the data that will go into the database (quantity, cart id, product id):';
        var_dump($quantity); var_dump($cartId); var_dump($productId);
        $stmt = $conn->prepare("UPDATE shoppingcart_items SET quantity=? WHERE shoppingcart_id=? AND product_id=?");
        $stmt->bind_param("iii", $quantity, $cartId, $productId);
    } else {
        $quantity = 1;
        echo 'Product is NOT FOUND in cart and this is the data that will go into the database (quantity, cart id, product id):';
        var_dump($quantity); var_dump($cartId); var_dump($productId);
        $stmt = $conn->prepare("INSERT INTO shoppingcart_items (shoppingcart_id, product_id, quantity) VALUES (?,?,?)");
        $stmt->bind_param("iii", $cartId, $productId, $quantity);
    }
    $stmt->execute();
    $lastId = $conn->insert_id;
    
    $stmt->close();
    $conn->close();
    return $lastId;
}


function isItemInCart($cartId, $productId) // checks if item user tries to add to cart is already in cart or not
{ 
    $conn = connectDatabase();

    $stmt = $conn->prepare("SELECT product_id FROM shoppingcart_items WHERE shoppingcart_id=? AND product_id=?");
    $stmt->bind_param("ii", $cartId, $productId);

    $stmt->execute();
    $itemsInCart = $stmt->get_result()->fetch_column();

    $stmt->close();
    $conn->close();

    return $itemsInCart;
}

function increaseItemQuantityByOne($cartId, $productId) // updates quantity of cart_item
{
    $currentQuantity = selectQuantityFromCartItem($cartId, $productId);
    $newQuantity = $currentQuantity + 1;
    return $newQuantity;
}

function getCartItemByProductId($productId)
{
    $conn = connectDatabase();
    $stmt = $conn->prepare("SELECT quantity FROM shoppingcart_items WHERE product_id=?");
    $stmt->bind_param("i", $productId);

    $stmt->execute();
    $cartItem = $stmt->get_result()->fetch_assoc();

    $stmt->close();
    $conn->close();

    return $cartItem;
}

function selectCartItemsByCartId($cartId)
{
    $conn = connectDatabase();

    $stmt = $conn->prepare("SELECT * FROM shoppingcart_items WHERE shoppingcart_id=?");
    $stmt->bind_param("i", $cartId);

    $stmt->execute();
    $itemsInCart = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    $conn->close();

    return $itemsInCart;
}

function selectQuantityFromCartItem($cartId, $productId)
{
    $conn = connectDatabase();

    $stmt = $conn->prepare("SELECT quantity FROM shoppingcart_items WHERE shoppingcart_id=? AND product_id=?");
    $stmt->bind_param("ii", $cartId, $productId);

    if ($stmt->execute()) {
        $itemQuantity = $stmt->get_result()->fetch_column();
    } else {
        $itemQuantity = 0;
    }

    $stmt->close();
    $conn->close();

    return $itemQuantity;
}

function calculateCartItemSubtotal($item, $quantity)
{
    $productId = $item['product_id'];
    $price = getProductPrice($productId);
    $subtotal = $price * $quantity;
    return $subtotal;
}

function calculateCartTotal($cartId)
{   
    $total = 0;
    $itemsInCart = selectCartItemsByCartId($cartId);
    foreach ($itemsInCart as $cartItem) {
        $quantity = $cartItem['quantity'];
        $itemTotal = calculateCartItemSubtotal($cartItem, $quantity);
        $total = $total  + $itemTotal;
    }
    return $total;
}

function getProductPrice($productId)
{
    $conn = connectDatabase();
    $stmt = $conn->prepare("SELECT price FROM products WHERE id=?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $price = $stmt->get_result()->fetch_column();
    $stmt->close();
    $conn->close();
    return $price;
}