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

function getAllProducts()
{
    $tableName = 'products';
    $column = ['*'];
    $products = getAllRows($tableName, $column);
    return $products;
}

function showProductListItem($product)
{
    echo
    '<div class="productlist_item">
        <a href="index.php?page=product&product='.$product['article_id'].'"><img src="'. $product['image'] .'" alt="product image"></a>
      <a href="index.php?page=product&product='.$product['article_id'].'"><h3>'. $product['name'] .'</h3></a>
      <p> Artikelno.:'. $product['article_id'] .'</p>
      <p>Prijs: €'. $product['price'] .'</p>
    </div>';
}

function showShopEnd()
{
    echo
    '</div>';
}



