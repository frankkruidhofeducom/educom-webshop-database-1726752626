<?php

function userExists(string $email): bool
{
    if (empty(getUserByEmail($email))) {
        return false;
    }
    return true;
}

function registrationSuccessful($formInput): bool
{
    if (registerNewUser($formInput)) {
        return true;
    }
    return false;
}

function registerNewUser($formInput): bool
{
    if (
        validRegisterFormInput($formInput) &&
        (!userExists($formInput['email'])) &&
        (passwordsMatch($formInput))
    ) {
        saveUserData($formInput);
        return true;
    }
    return false;
}

function passwordsMatch($formInput): bool
{
    $email = $formInput['email'];
    $password = $formInput['password'];

    $userLogin = getUserByEmail($email); //get password from db function
    if (array_search($password, $userLogin)) { // match pw from db with input pw
        return true;
    }
    return false;
}

function saveUserData($data): void
{
    $combineName = array($data['firstName'], $data['lastName']);
    $email = $data['email'];
    $password = $data['password'];

    $name = implode(" ", $combineName);

    createNewUser($name, $email, $password);
}

function authenticateUser(string $email, string $password): bool
{
    if (userExists($email)) {
        if (!array_search($password, getUser($email))) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

function validEmail(string $email): bool
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}
