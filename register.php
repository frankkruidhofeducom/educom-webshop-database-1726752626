<?php
function showRegisterPage()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = validateRegisterForm();
        if ($data['valid'] == false) {
            showRegisterForm($data);
        } else {
            showRegisterSuccess();
            require_once 'login.php';
            showLoginForm($data);
        }
    } else {
        $data = '';
        showRegisterForm($data);
    }
}

function validateRegisterForm()
{
    $firstName = $lastName = $email = $password = $passwordRepeat = '';

    $fullName = '';

    $firstNameErr = $lastNameErr = $emailErr = $emailExistsErr = $passwordErr = $passwordRepeatErr = '';

    $valid = false;


    $firstName = getPostVar('firstName');
    $lastName = getPostVar('lastName');
    $email = getPostVar('email');
    $password = getPostVar('password');
    $passwordRepeat = getPostVar('passwordRepeat');

    if (empty($firstName)) {
        $firstNameErr = "Voornaam is verplicht";
    } else {
        if (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ\-\s]*$/", $firstName)) {
            $firstNameErr = "Alleen letters en spaties zijn toegestaan";
        }
    }

    if (empty($lastName)) {
        $lastNameErr = "Achternaam is verplicht";
    } else {
        if (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ\-\s]*$/", $lastName)) {
            $lastNameErr = "Alleen letters en spaties zijn toegestaan";
        }
    }

    if (empty($email)) {
        $emailErr = "E-mail is verplicht";
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Ongeldig e-mailadres";
        }
    }

    if (empty($password)) {
        $passwordErr = "Kies een wachtwoord";
    }

    if (empty($passwordRepeat)) {
        $passwordRepeatErr = "Herhaal het gekozen wachtwoord";
    }

    if (!empty($password && $passwordRepeat)) {
        if (!($password === $passwordRepeat)) {
            $passwordRepeatErr = "Herhaald wachtwoord komt niet overeen";
        }
    }

    if (empty($firstNameErr) && (empty($lastNameErr)) && (empty($emailErr)) && (empty($passwordErr)) && (empty($passwordRepeatErr))) {
        $userInput = createUserArray($firstName, $lastName, $email, $password);
        if (userExists($email)) {
            $emailExistsErr = "Er bestaat al een account met dit e-mailadres";
        } else {
            saveUser($userInput);
        }

        if (empty($firstNameErr) && (empty($lastNameErr)) && (empty($emailErr)) && (empty($emailExistsErr)) && (empty($passwordErr)) && (empty($passwordRepeatErr))) {
            $valid = true;
        }
    }

    $data = array(
        'firstName' => $firstName,
        'lastName' => $lastName,
        'fullName' => $fullName,
        'email' => $email,
        'password' => $password,
        'passwordRepeat' => $passwordRepeat,
        'firstNameErr' => $firstNameErr,
        'lastNameErr' => $lastNameErr,
        'emailErr' => $emailErr,
        'emailExistsErr' => $emailExistsErr,
        'passwordErr' => $passwordErr,
        'passwordRepeatErr' => $passwordRepeatErr,
        'valid' => $valid
    );
    return $data;
}

function showRegisterForm($data)
{
    echo '<h2>Maak een account aan</h2>
    <div class="content">
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

function showRegisterSuccess()
{
    echo '<h3>
    Registratie gelukt!
    </h3>';
}
