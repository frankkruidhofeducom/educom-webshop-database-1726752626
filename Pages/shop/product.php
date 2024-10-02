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

    echo '
    <div class="productpage">
        <div>
            <img src="' . $product['image'] . '" alt="product image">
        </div>
        <div>
            <h2>' . $product['name'] . '</h2>
            <p>' . $product['description'] . '</p>
            <h3>€' . $product['price'] . '</h3>
        </div>
    </div>';
}
