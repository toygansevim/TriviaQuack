<?php
/**
 * @author Mason Hernnadez
 * filename: validateNewUser.php
 *
 * This file validates a user trying to signup fo TriviaQuack
 */
$errors = [];
$username = "";
$password = "";
$repeatPassword = "";
$email = "";

if(isset($_POST['submit'])) {
    global $errors, $f3, $username,
           $password, $repeatPassword, $email;
    validateUsername();
    validateEmail();
    validatePass();
    validateRepeatPass();
    //no errors with signing up
    if(empty($errors)) {
        //$f3->reroute('/home');
        echo "no errors!?";
    } else {
        //store past entries in fat free hive for sticky forms
        $f3->set('username', $username);
        $f3->set('email', $email);
        $f3->set('pass', $password);
        $f3->set('repeat_pass', $repeatPassword);

        //store errors in fat free hive for later use
        $f3->set('username_err', $errors['username_err']);
        $f3->set('email_err', $errors['email_err']);
        $f3->set('pass_err', $errors['pass_err']);
        $f3->set('repeat_pass_err', $errors['repeat_pass_err']);
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
        //does the user already exist
        if(doesUserExist($username))
            $errors['username_err'] = "Username already in use";

    } else {
        $errors['username_err'] = "Required field";
    }
}

/**
 * Finds out whether or not the username
 * being used to sign up already exists
 * in the database
 *
 * @param $username
 * @return boolean does the username exist
 */
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

    //Grab any rows with that username
    $sql = "SELECT * FROM triviaMembers WHERE username = :username";
    $statement = $dbh->prepare($sql);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    //if the row is empty user was not found, does not exist
    //empty, if empty return false
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

/**
 * Finds out whether or not the email
 * being used to sign up already exists
 * in the database
 *
 * @param $email
 * @return boolean does the email exist
 */
function doesEmailExist($email) {
    require '/home/mhernand/tqConfig.php';

    try {
        //Instantiate a database object
        $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        echo "Still connected to database!!!";
    } catch (PDOException $e) {
        echo $e->getMessage();
        return;
    }

    //Grab any rows holding that email
    $sql = "SELECT * FROM triviaMembers WHERE emailAddress = :email";
    $statement = $dbh->prepare($sql);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    //Does not exist (no rows with that email were retreived)
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

    if (!empty($_POST['repeat-pass'])) {
        $repeatPassword = htmlspecialchars($_POST['repeat-pass']);

        if($password!=$repeatPassword)
            $errors['repeat_pass_err'] = "Passwords do not match";

    } else {
        $errors['repeat_pass_err'] = "Required field";
    }
}