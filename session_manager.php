<?php

//////////* Log user in & out of session *//////////
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
    $_SESSION['shoppingCart']=array();
    return $_SESSION;
}

function doLogoutUser() 
{
    session_unset();
    return $_SESSION;
};


function endSession() //when?????
{
    session_reset();
}
