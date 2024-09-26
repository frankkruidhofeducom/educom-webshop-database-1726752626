<?php
require_once 'config.php';

//connect to database 
$conn = mysqli_connect(SERVER_NAME, DB_USERNAME, DB_PASS, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function getUserByEmail(string $email): array // find user by email adress
{
    // prepare statement
    $search_email = $GLOBALS['conn']->prepare("SELECT FROM users WHERE email=?");
    $search_email->bind_param("s", $email);

    // set parameters & execute statement 
    $search_email->execute();

    // get results 
    $user = $GLOBALS['conn']->query($search_email);

    // close statement
    $search_email->close();

    // return array
    return $user;
}

function createNewUser(string $name, string $email, string $password): void // create new user record 
{
    // prepare statement
    $create_user = $GLOBALS['conn']->prepare("INSERT INTO users (name, email, password) VALUES (?,?,?)");
    $create_user->bind_param("sss", $name, $email, $password);
    // set parameters and execute
    $create_user->execute();
    // close statement
    $create_user->close();
}

// closes opened database connection 
$conn->close();
