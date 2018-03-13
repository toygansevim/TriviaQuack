<?php

$errors = [];
$username;
$password;
$repeatPassword;
$email;

if(isset($_POST['submit'])) {
    global $errors, $f3;
    validateUsername();
    validateEmail();
    validatePass();
    validateRepeatPass();
    //no errors with signing up
    if(empty($errors)) {
        //$f3->reroute('/home');
        echo "no errors!?";
    } else {
        echo "we got errors";
        $f3->set('username_err', $errors['username_err']);
    }
}

/**
 * Checks for pre-existing username in database
 * and clears the username of possible sql insertion
 */
function validateUsername() {
    global $errors, $username;
    if (!empty($_POST['username'])) {
        $username = htmlspecialchars($_POST['username']);
        if(doesUserExist($username))
            $errors['username_err'] = "Username already in use";

    } else {
        $errors['username_err'] = "Required field";
    }
}

function doesUserExist($username) {
    require '/home/mhernand/tqConfig.php';

    try {
        //Instantiate a database object
        $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        echo "Still connected to database!!!";
    } catch (PDOException $e) {
        echo $e->getMessage();
        return;
    }

    $sql = "SELECT * FROM triviaMembers WHERE username = :username";
    $statement = $dbh->prepare($sql);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    return !empty($row);
}

/**
 * Checks for valid format of email, does
 * not check whether or not the email exists
 */
function validateEmail() {
    global $errors, $email;

    if (!empty($_POST['email'])) {
        $email = htmlspecialchars($_POST['email']);

        //invalid email format
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['email_err'] = "example@email.com";

        if(doesEmailExist($email))
            $errors['email_err'] =
                "Email already in use";

    } else {
        $errors['email_err'] = "Required field";
    }
}

function doesEmailExist($email) {
    require '/home/mhernand/config.php';

    try {
        //Instantiate a database object
        $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        echo "Still connected to database!!!";
    } catch (PDOException $e) {
        echo $e->getMessage();
        return;
    }

    $sql = "SELECT * FROM Members WHERE email = :email";
    $statement = $dbh->prepare($sql);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    return !empty($row);
}

function validatePass() {
    global $errors, $password;

    if (!empty($_POST['pass'])) {
        $password = htmlspecialchars($_POST['pass']);

    } else {
        $errors['pass_err'] = "Required field";
    }
}

function validateRepeatPass() {
    global $errors, $password, $repeatPassword;

    if (!empty($_POST['repeatPass'])) {
        $repeatPassword = htmlspecialchars($_POST['repeatPass']);

        if($password!=$repeatPassword)
            $errors['repeat_pass_err'] = "Passwords do not match";

    } else {
        $errors['repeat_pass_err'] = "Required field";
    }
}