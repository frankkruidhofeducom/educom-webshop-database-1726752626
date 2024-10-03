<?php

function getProductFromUrl() // gets articleId passed on in URL
{
    $key = 'product';
    if (isset($_GET[$key])) {
        $articleId = $_GET[$key];
    } else {
        $articleId = null;
    }
    return $articleId;
}


function showProductPage() // shows product page by getting product info from database with articleID
{
    $articleId = getProductFromUrl();
    $product = getProductbyArticleId($articleId);

    $request_type = $_SERVER['REQUEST_METHOD'];
    if ($request_type == 'POST') {
        $newCartItem = getCartItem();
        addToCart($newCartItem);
    }

    echo '
    <div class="productpage">
        <div>
            <img src="' . $product['image'] . '" alt="product image">
        </div>
        <div>
            <h2>' . $product['name'] . '</h2>
            <p>' . $product['description'] . '</p>
            <h3>€' . $product['price'] . '</h3>
            <form method="post">
                <input type="hidden" name="page" value="product">
                <input type="hidden" name="addToCart" value="' . $product['id'] . '">
                <input type="submit" value="Voeg toe aan winkelwagen">
            </form>
        </div>
    </div>';
}

function getCartItem(): array
{
    if (isset($_POST['addToCart'])) {
        $articleId = $_POST['addToCart'];
        $newCartItem = array("articleId" => $articleId, "quantity" => 1);
        return $newCartItem;
    }
}

function addToCart($productId)
{
    $shoppingcartId = getShoppingcartId();
    $quantity = setShoppingcartItemQuantity($shoppingcartId, $productId);
    var_dump($shoppingcartId);
    insertNewShoppingcartItem($shoppingcartId, $productId, $quantity);
}

function setShoppingcartItemQuantity($shoppingcartId, $productId)
{
    if (!isItemInShoppingcart($shoppingcartId, $productId)) {        
        $quantity = 1;
        return $quantity;
    } else {
        $quantity = increaseItemQuantityByOne($shoppingcartId, $productId);
        return $quantity;
    }
}
