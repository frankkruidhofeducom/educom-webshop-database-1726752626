<?php

function showShopPage()
{
    showShopStart();
    $allProducts = getAllProducts();
    foreach ($allProducts as $product){
        showProductListItem($product);
    }
    showShopEnd();
}

function showShopStart()
{
    echo
    '<div class="productlist">
    <h1>Shop</h1>';
}

function showShopEnd()
{
    echo
    '</div>';
}


function showProductListItem($product)
{
    echo
    '<div class="product">';
    // show product details
    echo '
    </div>';
}

