<?php

require_once 'user_service.php';

function showRegisterPage()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $formInput = getDataFromForm();
        if (!registrationSuccessful($formInput)) {
            showRegisterForm($formInput);
        } else {
            showRegisterSuccess($formInput);
        }
    } else {
        showRegisterForm();
    }
}

function getDataFromForm(): array // writes form input into array
{
    $firstName = getPostVar('firstName');
    $lastName = getPostVar('lastName');
    $email = getPostVar('email');
    $password = getPostVar('password');
    $passwordRepeat = getPostVar('passwordRepeat');

    $formInput = array(
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'password' => $password,
        'passwordRepeat' => $passwordRepeat
    );
    return $formInput;
}

function validRegisterFormInput($formInput): bool // checks if form input is complete and valid
{
    if (!empty($formInput['firstName'])) {
        if (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ\-\s]*$/", $formInput['firstName'])) {
            $firstNameErr = "Alleen letters en spaties zijn toegestaan";
        }
    }

    if (!empty($formInput['lastName'])) {
        if (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ\-\s]*$/", $formInput['lastName'])) {
            $lastNameErr = "Alleen letters en spaties zijn toegestaan";
        }
    }

    if (!empty($formInput['email'])) {
        if (!filter_var($formInput['email'], FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Ongeldig e-mailadres";
        }
    }

    if (!empty($formInput['password'] && $formInput['passwordRepeat'])) {
        if (!($formInput['password'] === $formInput['passwordRepeat'])) {
            $passwordRepeatErr = "Herhaald wachtwoord komt niet overeen";
        }
    }

    if (empty($firstNameErr) && (empty($lastNameErr)) && (empty($emailErr)) && (empty($passwordRepeatErr))) {
        return true;
    }
    return false;
}

function showUserExists() //shows error if client tries to register email that is already in database 
{
    echo 'Hier komt een error melding dat het account al bestaat en een link naar de login pagina';
}

function showRegisterForm() // shows register form 
{
    echo
    '<div class="content">
    <h2>Maak een account aan</h2>
    <form method="post" action="index.php?">
        <input type=hidden name="page" value="register">
        <fieldset>
        <div>
            <label for=firstName>Voornaam:</label>
            <input type="text" id="firstName" name="firstName" value= "';
    echo $data['firstName'] ?? '';
    echo '"> 
            <span class="error">';
    echo $data['firstNameErr'] ?? '';
    echo '</span>
        </div>
        <div>
            <label for=lastName>Achternaam:</label>
            <input type="text" id="lastName" name="lastName" value= "';
    echo $data['lastName'] ?? '';
    echo '">
            <span class="error">';
    echo $data['lastNameErr'] ?? '';
    echo '</span>
        </div>
        <div>
            <label for=email>E-mail:</label>
            <input type="email" id="email" name="email" value="';
    echo $data['email'] ?? '';
    echo  '">
            <span class="error">';
    echo $data['emailErr'] ?? '';
    echo '</span>
            <span class="error">';
    echo $data['emailExistsErr'] ?? '';
    echo '</span>
        </div>
        <div>
            <label for=password>Wachtwoord:</label>
            <input type="password" id="password" name="password" value="';
    echo $data['password'] ?? '';
    echo '">
            <span class="error">';
    echo $data['passwordErr'] ?? '';
    echo '</span>
        </div>
        <div>
            <label for=passwordRepeat>Herhaal je wachtwoord:</label>
            <input type="password" id="passwordRepeat" name="passwordRepeat" value="';
    echo $data['passwordRepeat'] ?? '';
    echo '">
            <span class="error">';
    echo $data['passwordRepeatErr'] ?? '';
    echo '</span>
        </div>
        <div>
            <input type="submit">
        </div>
        </fieldset>
    </form>
    </div>';
}

function showRegisterSuccess() // shows comfirmation that registration was successful 
{
    echo '<h3>
    Registratie gelukt!
    </h3>';
}
