<?php
/**
 * Created by PhpStorm.
 * User: toygan
 * Date: 2/26/18
 * Time: 2:03 AM
 *
 *
  CREATE TABLE triviaMembers (
        id int PRIMARY KEY AUTO_INCREMENT,
        username varchar(30) NOT NULL,
        password varchar(25) NOT NULL,
        email varchar(50) NOT NULL,
        totalScore int(11) DEFAULT NULL,
        joinDate date DEFAULT NULL,
        quackMember bit DEFAULT NULL
    );

  CREATE TABLE TriviaFriendsList (
        id INT NOT NULL,
        fid INT NOT NULL,
        PRIMARY KEY (id, fid),
        FOREIGN KEY (id) REFERENCES triviaMembers(id),
        FOREIGN KEY (fid) REFERENCES triviaMembers(id)
    );
 */

//needed config file
include("/home/mhernand/tqConfig.php");

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

    } catch (PDOException $ex) {
        echo "Connection failed" . "<br>";
        echo $ex->getMessage();
        return;
    }
}

//list leaders
function getLeaders()
{
    //global
    global $conn;

    //define
    $sql = "SELECT id, username, totalScore FROM triviaMembers ORDER BY totalScore";

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
 */
function retrieveUser($username)
{
    global $conn;

    //grabbing user based on username
    $sql = "SELECT * FROM triviaMembers WHERE username = :username";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);



    ///////////////////////////////////////////////////////////////
    /////   All of this can happen after finalizing Member class
    //////////////////////////////////////////////////////////////

    /*//store a new member object in session
    $member = new Member($result['id'], $result['username'],
                         $result['email'], $result['totalScore']);

    //grab friends list
    $sql = "SELECT * FROM TriviaFriendsList WHERE id = :id";
    $statement = $conn->prepare($sql);
    $statement->bindParam(':id', $member->getId(), PDO::PARAM_INT);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    /*
     * add each friend from the friend index
     * to the members friend array
     *
    $friends = [];
    foreach ($results as $result) {
        $frends[] = $result['fid'];
    }

    $member->setFriends($friends);*/

    return $result['id'];
}