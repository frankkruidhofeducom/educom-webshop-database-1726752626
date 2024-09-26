<?php
$SERVER_NAME;
$DB_NAME;
$DB_PASS;
$DB_USERNAME;

$conn = mysqli_connect($SERVER_NAME, $DB_USERNAME, $DB_PASS, $DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected succesfully";

$sql = "INSERT INTO users (name, email, password)
VALUES ('Enrique Iglesias', 'e.iglesias@gmail.com', 'pingpongsong!')";

if (mysqli_query($conn, $sql)) {
    echo "new record created succesfully";
} else {
    echo "error: " . $sql . "<br>" . mysqli_error($conn);
}
