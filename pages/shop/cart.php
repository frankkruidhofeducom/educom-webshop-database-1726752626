<?php

function showCartItem($productDetails, $quantity) // show box with product image, price, quantity etc.
{
    echo
    '<a href="index.php?page=product&product=' . $productDetails['article_id'] . '"><div>
        <img src="' . $productDetails['image'] . '" alt="product image">
        <div>
            <h3>' . $productDetails['name'] . '</h3>
            <p> Artikelno.:' . $productDetails['article_id'] . '</p>
            <p>Prijs: €' . $productDetails['price'] . '</p>
            <p>Aantal:' . $quantity . ' stuks</p>
        </div>
    </div>
    </a>';
}

function showShoppingCartStart()
{
    echo
    '<div class="shoppingcart">
        <h1>Winkelwagen</h1>';
}

function showShoppingCartEnd()
{
    echo
    // show cart total 
    // show button to payment page 
    '</div>';
}

function showShoppingCart()
{
    showShoppingCartStart();
    if (isset($_SESSION['shoppingcartId'])) {
        $itemsInCart = selectShoppingcartItemsByShoppingCartId($_SESSION['shoppingcartId']);
        if (!$itemsInCart) {
            echo '<p>Er zit nog niks in de winkelwagen</p>';
        } else {
            foreach ($itemsInCart as $item) {
                $productDetails = selectFromProductsByProductId($item);
                $quantity = selectQuantityFromCartItem($_SESSION['shoppingcartId'], $item);
                showCartItem($productDetails, $quantity);
            } /// also show quantity and subtotal 
        }
    }
    showShoppingCartEnd();
}
