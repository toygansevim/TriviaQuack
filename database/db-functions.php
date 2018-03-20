<?php
/**
 * Created by PhpStorm.
 * User: toygan
 * Date: 2/26/18
 * Time: 2:03 AM
 *
 *
 * CREATE TABLE triviaMembers (
 * id int PRIMARY KEY AUTO_INCREMENT,
 * username varchar(30) NOT NULL,
 * password char(40) NOT NULL,
 * email varchar(50) NOT NULL,
 * totalScore int(11) DEFAULT NULL,
 * joinDate date DEFAULT NULL,
 * quackMember bit DEFAULT NULL
 * );
 *
 * CREATE TABLE TriviaFriendsList (
 * id INT NOT NULL,
 * fid INT NOT NULL,
 * PRIMARY KEY (id, fid),
 * FOREIGN KEY (id) REFERENCES triviaMembers(id),
 * FOREIGN KEY (fid) REFERENCES triviaMembers(id)
 * );
 */

//needed config file
include "/home/tsevimgr/config.php";

//connection method
function connect()
{
    try
    {
        //instantiate a databse obejct
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_PERSISTENT, true);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //return connection
        return $conn;

    } catch (PDOException $ex)
    {
        echo "Connection failed" . "<br>";
        echo $ex->getMessage();
        return;
    }
}

/**
 * Returns array of top 10 players
 * for the leaderboard
 *
 * @return array
 */
function getLeaders()
{
    //global
    global $conn;

    //define
    $sql = "SELECT id, username, totalScore FROM triviaMembers ORDER BY totalScore DESC LIMIT 10";

    //prepare
    $statement = $conn->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}


/**
 * Adds a new user to the database
 *
 * @param $username
 * @param $password
 * @param $email
 */
function addMember($username, $password, $email)
{
    global $conn;

    $curentDate = date("Y-m-d");

    //define
    $sql = "
    INSERT INTO triviaMembers 
    (username, password, email, joinDate)
     VALUES
    (:username, SHA1(:password), :email, :joinDate)";

    $statement = $conn->prepare($sql);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);


    $statement->bindParam(':joinDate', $curentDate, PDO::PARAM_STR);
    $statement->execute();
}

/**
 * Grabs the user from the database based
 * on the username and returns a Member
 * object representation
 *
 * Can be passed string: 'guestAccessKey' to
 * return a Guest player
 *
 * @return Player object
 */
function retrieveUser($username)
{
    global $conn;

    if ($username == "guestAccessKey")
    {
        return new Guest();
    }

    //grabbing user based on username
    $sql = "SELECT * FROM triviaMembers WHERE username = :username";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    ///////////////////////////////////////////////////////////////
    /////   All of this can happen after finalizing Member class
    //////////////////////////////////////////////////////////////

    //store a new member object in session
    $member = new Member($result['id'], $result['username'], $result['email'],
        $result['joinDate'], $result['totalScore'], $result['totalPlayed'], explode(",", $result['categoryCounts']));

    return $member;
}


/**
 * Ultimately used to determine whether a user exists
 * if return is null, user does not exist
 *
 * @param $username The user that will be retrieved from the database
 * @return user name to be viewed in the profile page
 */
function retrieveUserProfile($username)
{
    global $conn;

    //grabbing user based on username
    $sql = "SELECT * FROM triviaMembers WHERE username = :username";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result['username'];
}


/**
 * Checks whether there is a person that playing the game
 * in the current session
 *
 * @return boolean
 */
function loggedIn()
{
    return !empty($_SESSION['user']);
}


/**
 * Updates a row for a member
 *
 * @param $member a Member object
 */
function updateMember($f3)
{

    $member = $_SESSION['user'];

    $username = $_SESSION['user']->getUsername();
    $score = $_SESSION['user']->getScore();


    //we don't need to update the database for a guest
    if ($_SESSION['user']->getUsername() != "Guest")
    {
        //Database function
        updateUserScore($member);
        updateTotalPlayed($member);
        updateCategoryCounts($member);
    }

    //Sets some fat free variables to display after updating
    $f3->set('username', $username);
    $f3->set('score', $score);

}


/**
 * This function will grab the current logged in user
 * and update their score in the database
 *
 * @param $username the user that is playing the game with email - password
 * @param $totalScore Total score they have gained from the rounds
 */
function updateUserScore($member)
{
    global $conn;

    //define sql
    $sql = "
    UPDATE triviaMembers 
    SET totalScore = :score
    WHERE username = :username";

    $statement = $conn->prepare($sql);
    $statement->bindParam(':username', $member->getUsername(), PDO::PARAM_STR);
    $statement->bindParam(':score', $member->getScore(), PDO::PARAM_INT);

    $statement->execute();
}


/**
 * This method will update the user's total played
 * question amount overall application
 *
 * @param $username the user that is actively playing
 * @param $totalPlayed amounts of questions played
 */
function updateTotalPlayed($member)
{
    global $conn;

    //define sql
    $sql = "UPDATE triviaMembers SET totalPlayed = :totalPlayed WHERE username = :username";

    //prepare
    $statement = $conn->prepare($sql);

    //bind Param
    $statement->bindParam(':username', $member->getUsername(), PDO::PARAM_STR);
    $statement->bindParam(':totalPlayed', $member->getTotalPlayed(), PDO::PARAM_INT);

    //execute
    $statement->execute();
}


/**
 * Updates the played categories as a string that will be converted with an implode to retrieve
 * array's individual values
 *
 * @param $username player
 * @param $categoryCounts categories choosen in the game
 */
function updateCategoryCounts($member)
{
    global $conn;

    //define sql
    $sql = "UPDATE triviaMembers SET categoryCounts = :categoryCounts WHERE username = :username";

    //prepare
    $statement = $conn->prepare($sql);

    //bind Param
    $statement->bindParam(':username', $member->getUsername(), PDO::PARAM_STR);
    $statement->bindParam(':categoryCounts', implode(",", $member->getCategoryCounts()),
        PDO::PARAM_STR);

    //execute
    $statement->execute();
}


/**
 * Checks whether the user exists
 *
 * @param $username
 * @return bool does the user exist
 */
function userExists($username)
{
    return retrieveUserProfile($username) != null;
}