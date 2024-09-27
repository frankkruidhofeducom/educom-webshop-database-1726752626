<?php

function userExists(string $email): bool // check if e-mail is registered in database
{
    if (empty(getUserByEmail($email))) {
        return false;
    }
    return true;
}

function registrationSuccessful($formInput): bool //true if new user could be saved to database successfully, false if not
{
    if (doRegisterNewUser($formInput)) {
        return true;
    }
    return false;
}

function doRegisterNewUser($formInput): bool // decides if register attempt can go through and calls saveUserData function
{
    if (
        validRegisterFormInput($formInput) &&
        (!userExists($formInput['email'])) &&
        (repeatPassword($formInput))
    ) {
        saveUserData($formInput);
        return true;
    }
    return false;
}

function repeatPassword($formInput): bool //checks if password repeat password is identical
{
    if ($formInput['password'] == $formInput['passwordRepeat']) {
        return true;
    }
    return false;
}

function verifyLogin($formInput): bool // verifies if user login attempt matches user login in database 
{
    $email = $formInput['email'];
    $password = $formInput['password'];

    $userLogin = getUserByEmail($email); //get password from db function
    if (array_search($password, $userLogin)) { // match pw from db with input pw
        return true;
    }
    return false;
}

function saveUserData($data): void //formats new user record and calls createNewUser function in database
{
    $combineName = array($data['firstName'], $data['lastName']);
    $email = $data['email'];
    $password = $data['password'];

    $name = implode(" ", $combineName);

    createNewUser($name, $email, $password);
}

function validEmail(string $email): bool // validates email input 
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}
