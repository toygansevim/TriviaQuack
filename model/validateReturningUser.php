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

if(isset($_POST['submit'])) {
    global $errors, $f3, $username, $password, $email, $repeatPassword;
    validateUsername();
    validatePass();
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
        if(!doesUserExist($username))
            $errors['username_err'] = "Username doesn't exist";

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

function validatePass() {
    global $errors, $password;

    if (!empty($_POST['pass'])) {
        $password = htmlspecialchars($_POST['pass']);

    } else {
        $errors['pass_err'] = "Required field";
    }
}