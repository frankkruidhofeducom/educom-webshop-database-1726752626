<?php
require_once 'session_manager.php';




function showActiveMenu()
{
    echo
    '<div class="navbar">
    <ul>
        <li><a href="index.php?page=home">HOME</a></li>
        <li><a href="index.php?page=about">ABOUT</a></li>
        <li><a href="index.php?page=contact">CONTACT</a></li>
        <li><a href="index.php?page=logout">LOGOUT ' . $_SESSION['name'] . '</a></li>
    </ul>
    </div>';
}

function showInactiveMenu()
{
    echo
    '<div class="navbar">
    <ul>
        <li><a href="index.php?page=home">HOME</a></li>
        <li><a href="index.php?page=about">ABOUT</a></li>
        <li><a href="index.php?page=contact">CONTACT</a></li>
        <li><a href="index.php?page=register">REGISTER</a></li>
        <li><a href="index.php?page=login">LOGIN</a></li>
    </ul>
    </div>';
}
