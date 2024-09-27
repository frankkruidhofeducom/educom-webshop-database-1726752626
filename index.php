<?php
session_start();

require_once 'database/config.php';
require_once 'database/database.php';
require_once 'user_service.php';
require_once 'session_manager.php';

// TOP LEVEL
$page = getRequestedPage();
$userLoggedIn = isUserLoggedIn();
showResponsePage($page, $userLoggedIn);


// FUNCTIONS
function getRequestedPage()
{
    $request_type = $_SERVER['REQUEST_METHOD'];
    if ($request_type == 'POST') {
        $requested_page = getPageFromPost('page', 'home');
    } else {
        $requested_page = getPageFromUrl('page', 'home');
    }
    return $requested_page;
}

function getPageFromPost($key, $default = '')
{
    if (isset($_POST[$key])) {
        return $_POST[$key];
    } else {
        return $default;
    }
};

function getPageFromUrl($key, $default = '')
{
    if (isset($_GET[$key])) {
        return $_GET[$key];
    } else {
        return $default;
    }
};

function showResponsePage($page, $userLoggedIn)
{
    showDocumentStart();
    showHeadSection();
    showBodySection($page, $userLoggedIn);
    showDocumentEnd();
};

function showDocumentStart()
{
    echo '<!DOCTYPE html>
    <html>';
};

function showHeadSection()
{
    echo '<head>
    <link rel="stylesheet" href="css/stylesheet.css">
    <title>Educom Webshop Basis</title>
    </head>';
};

function showBodySection($page, $userLoggedIn)
{
    showBodyStart();
    showMenu($userLoggedIn);
    include 'pages/header.php';
    showHeader();
    showContent($page);
    include 'pages/footer.php';
    showFooter();
    showBodyEnd();
};

function showDocumentEnd()
{
    echo '</html>';
};

function showBodyStart()
{
    echo '<body>';
};

function showMenu($userLoggedIn)
{
    require_once 'pages/menu.php';
    buildMenu($userLoggedIn);
}

function showContent($page)
{
    switch ($page) {
        case 'home':
            require_once 'pages/home.php';
            showHomePage();
            break;
        case 'about':
            require_once 'pages/about.php';
            showAboutPage();
            break;
        case 'contact':
            require_once 'pages/contact.php';
            showContactPage();
            break;
        case 'register':
            require_once 'pages/register.php';
            showRegisterPage();
            break;
        case 'login';
            require_once 'pages/login.php';
            showLoginPage();
            break;
        case 'logout':
            doLogoutUser();
            showMenu(false);
            showContent('home');
        default:
            require_once 'pages/home.php';
            break;
    }
};

function showBodyEnd()
{
    echo '</body>';
};

function cleanString($string)
{
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}

function getPostVar($key, $default = '')
{
    if (isset($_POST[$key])) {
        return cleanString($_POST[$key]);
    } else {
        return $default;
    }
}
