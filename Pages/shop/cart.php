<?php

function getCartItems()
{
    //get cart items from session manager
}


function showCartItem()
{
    // show box with product image, price, quantity etc.
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
    $productsInCart = getCartItems();
    showShoppingCartStart();
    foreach ($productsInCart as $cartItem) {
        showCartItem($cartItem);
    }
    showShoppingCartEnd();
}