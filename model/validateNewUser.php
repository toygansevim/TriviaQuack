<?php
/**
 * @author Mason Hernanadez
 * filename: validateNewUser.php
 * condition: functioning/complete
 *
 * This file validates a user trying to sign-up for TriviaQuack
 *
 */

//did the file call come from javaScript or submit
if (!isset($_POST['fromJS'])) {

    require_once "database/db-functions.php";
    $conn = connect();

    validateUsername($username, $errors, $conn);
    validateEmail($email, $errors, $conn);
    validatePass($password, $errors);
    validateRepeatPass($password, $repeatPassword, $errors);

    //no errors were developed
    if (empty($errors)) {

        //add member to database using db-functions.addMember()
        addMember($username, $password, $email);

        //store the user in the session (logged in)
        $_SESSION['user'] = retrieveUser($username);

        //reroute to home page of game
        $f3->reroute("./home");

    //They had errors, record the errors and past entries
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

//The request came from javascript
} else {

    require_once "../database/db-functions.php";
    $conn = connect();

    $errors = [];
    $username = "";
    $password = "";
    $savedPassword = "";

    //the request was made for username validation
    if (isset($_POST['forusername'])) {
        validateUsername($username, $errors, $conn);
        echo $errors['username_err'];
    }

    //the request was made for email validation
    if (isset($_POST['foremail'])) {
        validateEmail($email, $errors, $conn);
        echo $errors['email_err'];
    }

    //the request was made for password validation
    if (isset($_POST['forpass'])) {
        validatePass($password, $errors);
        echo $errors['pass_err'];
    }

    //the request was made for repeat-password validation
    if (isset($_POST['forrepeatpass'])) {
        validatePass($password, $errors);
        validateRepeatPass($password, $savedPassword, $errors);
        echo $errors['repeat_pass_err'];
    }
}




/**
 * Checks that username is entered,
 * is "clean", and not already taken
 *
 * @param $username
 * @param $errors
 */
function validateUsername(&$username, &$errors, &$conn)
{
    //they entered their username
    if (!empty($_POST['username'])) {

        //clean the data
        $username = htmlspecialchars($_POST['username']);


        //does the user already exist
        if (doesUserExist($username, $conn))
            $errors['username_err'] = "Username already in use";


    //They never entered their username
    } else {
        $errors['username_err'] = "Required field";
    }
}


/**
 * Check that username is in database
 *
 * @param &$username
 * @return boolean does the username exist
 */
function doesUserExist($username, &$conn)
{

    //Grab any rows with that username
    $sql = "SELECT * FROM triviaMembers WHERE username = :username";
    $statement = $conn->prepare($sql);
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
function validateEmail(&$email, &$errors, &$conn)
{
    //they have entered their email
    if (!empty($_POST['email'])) {
        $email = htmlspecialchars($_POST['email']);


        //invalid email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors['email_err'] = "example@email.com";


        //does email exist already
        if (doesEmailExist($email, $conn))
            $errors['email_err'] = "Email already in use";


    //they have not entered their email
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
 * @return bool
 */
function doesEmailExist($email, &$conn)
{
    //Grab row based on email
    $sql = "SELECT * FROM triviaMembers WHERE email = :email";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    //Does not exist (no rows with that email were retrieved)
    return !empty($row);
}


/**
 * Validates password was entered and "clean"
 *
 * @param $password
 * @param $errors
 */
function validatePass(&$password, &$errors)
{
    //they entered their password
    if (!empty($_POST['pass'])) {
        $password = htmlspecialchars($_POST['pass']);


    //they have not entered their password
    } else {
        $errors['pass_err'] = "Required field";
    }
}


/**
 * Validates that repeat password was entered,
 * is "clean", and matches the entered password
 *
 * @param $password
 * @param $repeatPassword
 * @param $errors
 */
function validateRepeatPass(&$password, &$repeatPassword, &$errors)
{
    //they entered their repeat password
    if (!empty($_POST['repeat-pass'])) {

        //clean the data
        $repeatPassword = htmlspecialchars($_POST['repeat-pass']);

        //do the passwords match
        if ($password != $repeatPassword)
            $errors['repeat_pass_err'] = "Passwords do not match";


    //they did not enter their password
    } else {
        $errors['repeat_pass_err'] = "Required field";
    }
}