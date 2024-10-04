<?php

function showCartItem($item) // show box with product image, price, quantity etc.
{
    $productDetails = selectFromProductsByProductId($item['product_id']);
    $quantity = $item['quantity'];
    $subtotal = calculateCartItemSubtotal($item, $quantity);
    echo
    '<a href="index.php?page=product&product=' . $productDetails['article_id'] . '"><div>
        <img src="' . $productDetails['image'] . '" alt="product image">
        <div>
            <h3>' . $productDetails['name'] . '</h3>
            <p> Artikelno.:' . $productDetails['article_id'] . '</p>
            <p>Prijs: €' . $productDetails['price'] . '</p>
            <p>Aantal:' . $quantity . ' stuks</p>
            <h4>Subtotaal: €' . $subtotal . '</h4>
        </div>
    </div>
    </a>';
}

function showShoppingCartStart()
{
    echo
    '<div class="cart">
        <h1>Winkelwagen</h1>';
}

function showShoppingCartEnd()
{

    echo '</div>';
}

function showShoppingCart()
{
    showShoppingCartStart();
    $cartId = getCartId();
    $itemsInCart = selectCartItemsByCartId($cartId);
    if (!$itemsInCart) {
        echo '<p>Er zit nog niks in de winkelwagen</p>';
    } else {
        foreach ($itemsInCart as $item) {
            showCartItem($item);
        }
        $cartTotal = calculateCartTotal($cartId);
        echo 
        '<div class="cart-total">
            <h2>Totaal: €' . $cartTotal . '</h2>
            <input type="submit" value="Afrekenen">
        </div>';
    }
    showShoppingCartEnd();
}
