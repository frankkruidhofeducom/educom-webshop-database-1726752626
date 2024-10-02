<?php

function showCartItem($cartItem) // show box with product image, price, quantity etc.
{
    echo
    '<a href="index.php?page=product&product=' . $cartItem['article_id'] . '"><div>
        <img src="' . $cartItem['image'] . '" alt="product image">
        <div>
            <h3>' . $cartItem['name'] . '</h3>
            <p> Artikelno.:' . $cartItem['article_id'] . '</p>
            <p>Prijs: €' . $cartItem['price'] . '</p>
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
    foreach ($_SESSION['shoppingCart'] as $articleId) {
        $cartItem = getProductbyArticleId($articleId);
        showCartItem($cartItem);
    }
    showShoppingCartEnd();
}
