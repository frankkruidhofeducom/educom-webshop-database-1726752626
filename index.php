<?php
session_start();

require_once 'file_repository.php';
require_once 'user_service.php';
require_once 'session_manager.php';

// TOP LEVEL
$page = getRequestedPage();
showResponsePage($page);

// FUNCTIONS
function getRequestedPage()
{
    $request_type = $_SERVER['REQUEST_METHOD'];
    if($request_type=='POST'){
        $requested_page = getPageFromPost('page','home');
    } else {
        $requested_page = getPageFromUrl('page', 'home');
    }
    return $requested_page;
}

function getPageFromPost($key, $default = '')
{
    if(isset($_POST[$key])){
        return $_POST[$key];
    } else {
        return $default;
    }
};

function getPageFromUrl($key, $default='')
{
    if(isset($_GET[$key])){
        return $_GET[$key];
    } else {
        return $default;
    }
};

function showResponsePage($page)
{
    showDocumentStart();
    showHeadSection();
    showBodySection($page);
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

function showBodySection($page)
{
    showBodyStart();
    showMenu();
    include 'header.php';
    showHeader();
    showContent($page);
    include 'footer.php';
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

function showMenu ()
{
   require_once 'menu.php';
   if (isset($_SESSION['loggedIn'])) {
    showActiveMenu();
   } else  {
    showInactiveMenu();
   }
}

function showContent ($page)
{
    switch($page)
    {
        case 'home':
            require_once 'home.php';
            showHomePage();
            break;
        case 'about':
            require_once 'about.php';
            showAboutPage ();
            break;
        case 'contact':
            require_once 'contact.php';
            showContactPage();
            break;
        case 'register':
            require_once 'register.php';
            showRegisterPage();
            break;
        case 'login';
            require_once 'login.php';
            showLoginPage();
            break;
        case 'logout':
            require_once 'logout.php';
            require_once 'home.php';
            doLogoutUser();
            showHomePage();
        default:
            require_once 'home.php';
            break;
    }

};

function showBodyEnd ()
{
    echo '</body>';
};

function cleanString($string){
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}

function getPostVar ($key, $default=''){
    if(isset($_POST[$key])){
        return cleanString($_POST[$key]);
    } else {
        return $default;
    }
}

