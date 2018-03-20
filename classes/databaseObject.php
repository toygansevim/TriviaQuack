<?php
/**
 * Created by PhpStorm.
 * User: toygan
 * Date: 3/6/18
 * Time: 12:30 AM
 */
require("/home/tsevimgr/config.php");

class DatabaseObject
{

    /**
     * This function connects and returns new database object
     *
     * @return database object
     */
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


    /**
     * Updates a row for a member
     *
     * @param $member a Member object
     */
    function updateMember($f3)
    {

        //RETRIEVE USER
        $member = $_SESSION['user'];


        //SET THE HIVE OF THE CURRENT LOGGED IN USER
        $f3->set('username', $member->getUsername());
        $f3->set('score', $member->getScore());



        //we don't need to update the database for a guest
        if ($member->getUsername() == "Guest") return;
        global $conn;

        //define
        $sql = "
            UPDATE triviaMembers
            SET totalScore = :score
            WHERE username = :username";

        //        PREPARE
        $statement = $conn->prepare($sql);
        //BIND

        $statement->bindParam(':username', $member->getUsername(), PDO::PARAM_STR);
        $statement->bindParam(':score', $member->getScore(), PDO::PARAM_INT);
        $statement->execute();


    }

    /**
     * Is the user logged in or not
     *
     * @return boolean
     */
    function loggedIn()
    {
        return !empty($_SESSION['user']);
    }
}