<?php

function showLoginPage()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $formInput = getLoginAttempt();
        if (verifyLogin($formInput)) {
            doLoginUser($formInput);
            showContent('home');
            showMenu('true');
        } else {
            showLoginForm();
        }
    } else {
        showLoginForm();
    }
}

function getLoginAttempt(): array
{
    $email = getPostVar('email');
    $password = getPostVar('password');

    $formInput = array('email' => $email, 'password' => $password);

    return $formInput;
}


function showLoginForm()
{
    echo 
    '<div class="content">
    <h1>Login</h1>
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

