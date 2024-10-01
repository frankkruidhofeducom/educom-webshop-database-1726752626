<?php
require_once 'database/database.php';

function getAllProducts()
{
    $tableName = 'products';
    $column = ['*'];
    $products = getAllRows($tableName, $column);
    return $products;
}

