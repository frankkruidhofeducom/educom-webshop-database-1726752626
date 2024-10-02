<?php
require_once 'session_manager.php';

function buildMenu($userLoggedIn)
{
    showMenuStart();
    showFixedMenuItems();
    showDynamicMenuItems($userLoggedIn);
    showMenuEnd();
}

function showMenuStart()
{
    echo
    '<div class="navbar">
    <ul>';
}

function showFixedMenuItems()
{
    echo
    '<li><a href="index.php?page=home">Home</a></li>
        <li><a href="index.php?page=shop">Shop</a></li>
        <li><a href="index.php?page=contact">Contact</a></li>';
}

function showMenuEnd()
{
    echo
    '</ul>
    </div>';
}

function showDynamicMenuItems($userLoggedIn)
{
    if ($userLoggedIn) {
        showLogoutButton();
        showCartButton();
    } else {
        showLoginButton();
        showRegisterButton();
    }
}

function showLogoutButton()
{
    echo 
    '<li><a href="index.php?page=logout">Logout ' . $_SESSION['name'] . '</a></li>';
}

function showCartButton()
{
    echo 
    '<li><a href="index.php?page=cart">Cart</a></li>';
}

function showLoginButton()
{
    echo
    '<li><a href="index.php?page=login">Log in</a></li>';
}

function showRegisterButton()
{
    echo
    '<li><a href="index.php?page=register">Register</a></li>';
}