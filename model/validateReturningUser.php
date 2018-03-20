<?php
/**
 * @author Mason Hernnadez
 * filename: validateNewUser.php
 *
 * This file validates a user trying
 * to login fo TriviaQuack
 */

//did the file call come from javaScript or submit
if (!isset($_POST['fromJS'])) {

    require_once "database/db-functions.php";
    $conn = connect();

    //initialize variables used in validation
    $errors = [];
    $username;
    $password;
    $savedPassword;

    validateUsername($username, $savedPassword, $errors, $conn);
    validatePass($password, $savedPassword, $errors, $conn);

    //no errors were developed
    if (empty($errors)) {
        $_SESSION['user'] = retrieveUser($username);

        //reroute to home page of game
        $f3->reroute("./home");

    //Either something wasn't entered or was entered incorrectly
    } else {
        //store past entries in fat free hive for sticky forms
        $f3->set('username', $username);
        $f3->set('pass', $password);

        //store errors in fat free hive for later use
        $f3->set('username_err', $errors['username_err']);
        $f3->set('pass_err', $errors['pass_err']);
    }

//The request came from javascript
} else {

    require_once "../database/db-functions.php";
    $conn = connect();

    $errors = [];
    $username;
    $password;
    $savedPassword = "";

    //the request was made for username validation
    if (isset($_POST['forusername'])) {
        validateUsername($username, $savedPassword, $errors, $conn);
        echo $errors['username_err'];
    }

    //the request was made for password validation
    if (isset($_POST['forpass'])) {
        validateUsername($username, $savedPassword, $errors, $conn);
        validatePass($password, $savedPassword, $errors, $conn);
        echo $errors['pass_err'];
    }
}

/**
 * Checks for pre-existing username in database
 * and clears the username of possible sql insertion
 */
function validateUsername(&$username, &$savedPassword, &$errors, &$conn)
{
    //Did they enter their username
    if (!empty($_POST['username'])) {
        $username = htmlspecialchars($_POST['username']);

        //does the user actually exist
        if (!doesUserExist($username, $savedPassword, $conn))
            $errors['username_err'] = "Username doesn't exist";

        //They did not enter their username
    } else {
        $errors['username_err'] = "Required field";
    }
}

/**
 * Finds if user exists in database
 *
 * @param $username
 * @return boolean does the username exist
 */
function doesUserExist(&$username, &$savedPassword, &$conn)
{
    //Grab any rows with that username
    $sql = "SELECT * FROM triviaMembers WHERE username = :username";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    /*
     * if the row is not empty, the user was found, save his password
     * to check it against the entered password in validate password
     * if empty return false
     */
    if (!empty($row)) {
        $savedPassword = $row['password'];
        return true;
    } else {
        return false;
    }
}

/**
 * Checks that password was entered and correct
 */
function validatePass(&$password, &$savedPassword, &$errors)
{
    //Did they type there password in?
    if (!empty($_POST['pass'])) {
        $password = htmlspecialchars($_POST['pass']);

        //Did they enter the correct password
        if ($savedPassword != "" && $savedPassword != sha1($password)) {
            $errors['pass_err'] = "Incorrect password";
    }
        //They did not enter their password
    } else {
        $errors['pass_err'] = "Required field";

    }
}