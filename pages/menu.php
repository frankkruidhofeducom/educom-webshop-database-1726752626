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
    '<li><a href="index.php?page=home">HOME</a></li>
        <li><a href="index.php?page=about">ABOUT</a></li>
        <li><a href="index.php?page=contact">CONTACT</a></li>';
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
    } else {
        showLoginButton();
        showRegisterButton();
    }
}

function showLogoutButton()
{
    echo 
    '<li><a href="index.php?page=logout">LOGOUT ' . $_SESSION['name'] . '</a></li>';
}

function showLoginButton()
{
    echo
    '<li><a href="index.php?page=login">LOG IN</a></li>';
}

function showRegisterButton()
{
    echo
    '<li><a href="index.php?page=register">REGISTER</a></li>';
}