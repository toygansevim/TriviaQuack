<?php
/**
 * @author Mason Hernnadez
 * filename: validateNewUser.php
 *
 * This file validates a user trying
 * to login fo TriviaQuack
 */

$errors = [];
$username = "";
$password = "";
$savedPassword = "";

if(isset($_POST['submit'])) {
    global $errors, $f3, $username, $password, $savedPassword;
    validateUsername();
    validatePass();
}

/**
 * Checks for pre-existing username in database
 * and clears the username of possible sql insertion
 */
function validateUsername() {
    global $errors, $username;

    //Did they enter their username
    if (!empty($_POST['username'])) {
        $username = htmlspecialchars($_POST['username']);

        //does the user actually exist
        if(!doesUserExist($username))
            $errors['username_err'] = "Username doesn't exist";

    //They did not enter their username
    } else { $errors['username_err'] = "Required field"; }
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
    global $savedPassword, $conn;

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
    } else { return false; }
}

/**
 * Validate that they entered their password
 * and it is correct
 */
function validatePass() {
    global $errors, $savedPassword, $username, $password;

    //Did they type there password in?
    if (!empty($_POST['pass'])) {
        $password = htmlspecialchars($_POST['pass']);

        //Did they enter the correct password
        if($savedPassword!=""&&$savedPassword!=sha1($password))
            $errors['pass_err'] = "Incorrect password";

    //They did not enter their password
    } else { $errors['pass_err'] = "Required field"; }
}