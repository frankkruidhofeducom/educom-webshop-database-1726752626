<?php
require_once 'config.php';

function connectDatabase() //connect to database 
{
    // establish connection
    $conn = new mysqli(SERVER_NAME, DB_USERNAME, DB_PASS, DB_NAME);
    // check connection 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . "<br>Er kan op dit moment geen verbinding gemaakt worden met het gebruikersbestand");
    }

    return $conn;
}

function createNewUser(string $name, string $email, string $password) // insert new user record into database
{
    $conn = connectDatabase();

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    $stmt->execute();

    if ($stmt->errno != 0) {
        echo "Er ging iets fout... " . $stmt->error;
    }
    $stmt->close();

    $conn->close();
}


function getUserByEmail(string $email): ?array // find user in users table by email adress, returns array
{
    // prepare statement
    $conn = connectDatabase();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);

    // set parameters & execute statement 
    $stmt->execute();
    $foundUsers = $stmt->get_result()->fetch_assoc();

    // close statement
    $stmt->close();
    $conn->close();
    // return array
    return $foundUsers;
}
