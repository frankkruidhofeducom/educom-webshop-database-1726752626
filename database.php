<?php
require_once 'config.php';

//connect to database 
function connectDatabase()
{
    $conn = mysqli_connect(SERVER_NAME, DB_USERNAME, DB_PASS, DB_NAME);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        return $conn;
    }
}

function getUserByEmail(string $email)  // find user by email adress
{
    // prepare statement
    $conn = connectDatabase();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);

    // set parameters & execute statement 
    $stmt->execute();
    $stmt->bind_result($foundUserId, $foundName, $foundEmail, $foundPassword); // get results 

    while ($stmt->fetch()) {
        printf("user_id = %i, name = %s, email = %s, password = %s\n", $foundUserId, $foundName, $foundEmail, $foundPassword);
    }

    // if there are no results, return false

    // close statement
    $stmt->close();
    $conn->close();
    // return array
    // return $user;
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
