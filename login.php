<?php
require_once 'session_manager.php';

function showLoginPage()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = getPostVar('email');
        $password = getPostVar('password');
        if (validLoginForm($email, $password)) {
            echo 'gebruiker wordt ingelogd';
            doLoginUser($email);
            showLoginSucceeded();
        } else {
            showLoginForm($email, $password);
            echo 'foute login, reponse page met login form en link naar registratie';
        }
    } else {
        showLoginForm();
    }
}

function validLoginForm($email, $password): bool
{
    if (authenticateUser($email, $password)) {
        return true;
    }
    return false;
}



function showLoginForm()
{
    echo '<h2>Login</h2>
    <div class="content">
    <form method="post" action="index.php?">
        <input type=hidden name="page" value="login">
        <fieldset>
        <div>
            <label for=email>E-mail:</label>
            <input type="email" id="email" name="email" value="';
    echo $email ?? '';
    echo '">
            <div>
                <span class="error"></span>
            </div>
        </div>
        <div>
            <label for=password>Wachtwoord:</label>
            <input type="password" id="password" name="password" value="';
    echo $password ?? '';
    echo '">
            <div>
                <span class="error"></span>
            </div>
        </div>
        <div>
            <input type="submit">
        </div>
        </fieldset>
    </form>
    </div>';
}

function doLoginUser($email)
{
    $user = getUser($email);    // haal rest variabelen op uit getuser 
    setUserSession($user);     //geeft variabelen door aan session manager 

}

function showLoginSucceeded()
{
    echo '<div class="content">
    <h2>Welkom terug,';
    echo ($_SESSION['name']);
    echo '!</h2>
    <p>Hier komt een bevestiging</p>
</div>';
}
