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
                <input type="hidden" name="addToCart" value="'. $product['article_id'] .'">
                <input type="submit" value="Voeg toe aan winkelwagen">
            </form>
        </div>
    </div>';

}

function getCartItem():string
{
    if (isset($_POST['addToCart'])) {
        $newCartItem = $_POST['addToCart'];
        return $newCartItem;
    } 
}

function addToCart($newCartItem): array
{    
    if (!array_search($newCartItem, $_SESSION['shoppingCart']))
    {
        $_SESSION['shoppingCart'][]= $newCartItem;///// not finished 
    }
    return $_SESSION['shoppingCart'];
    
    // check if item is already in cart
    // if item is already in cart, add +1 to array key

}
