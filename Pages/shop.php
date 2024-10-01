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
    <h1>Alle producten</h1>';
}

function showShopEnd()
{
    echo
    '</div>';
}


function showProductListItem($product)
{
    echo
    '<div class="product">
        <img src="'. $product['image'] .'" alt="product image">
      <h3>'. $product['name'] .'</h3>
      <p> Artikelno.:'. $product['article_id'] .'</p>
      <p>Prijs: €'. $product['price'] .'</p>
      <p> Productbeschrijving: '. $product['description'] .'</p>
    </div>';
}

