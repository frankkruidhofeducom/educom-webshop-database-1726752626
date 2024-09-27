<?php
function isUserLoggedIn() //checks if a user is logged into the session
{
    if (isset($_SESSION['loggedIn'])) {
        return true;
    }
    return false;
}

function doLoginUser(array $loginInput)
{
    $user = getUserByEmail($loginInput['email']);    // get user data from database 

    $_SESSION['name'] = $user['name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['password'] = $user['password'];
    $_SESSION['loggedIn'] = 'yes';
    return $_SESSION;
}

function doLogoutUser() 
{
    $_SESSION['name'] = null;
    $_SESSION['email'] = null;
    $_SESSION['password'] = null;
    $_SESSION['loggedIn'] = null;
    return $_SESSION;
};

function endSession() //when?????
{
    session_reset();
}
