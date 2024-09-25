<?php
define('USER_FILE_NAME', "users/users.txt");

function getUser(string $email): ?array {   
    $userData = fopen(USER_FILE_NAME, "r");
    try {
        while (!feof($userData)){
            $line = fgets($userData);
            $parts = transformRecordToArray($line);
            if($parts[0] == $email) {
                $foundUser = array('email' => $parts[0], 'name' => $parts[1], 'password' => $parts[2]);
                return $foundUser;
            }
        }
        return null;
        }
        finally {
            fclose($userData);
        }
    }


function saveUser(array $userArray): void
{
    $newUser = transformArrayToRecord($userArray);
    $userData = fopen(USER_FILE_NAME, "a");
    try {
        fwrite($userData, $newUser);
    }
    finally {
        fclose($userData);
    }
}

function transformRecordToArray(string $userRecord): array
{
    $newArray = explode('|', $userRecord);
    return $newArray;
}

function transformArrayToRecord(array $userArray): string
{
    $newRecord = implode('|', $userArray);
    return $newRecord;
}