<?php
/**
 * Created by PhpStorm.
 * User: toygan
 * Date: 3/6/18
 * Time: 12:30 AM
 */

class DatabaseObject
{
    function connect()
    {
        try
        {
            //instantiate a databse obejct
            $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_PERSISTENT, true);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected to database for Trivia Quack!";
            //return connection
            return $conn;

        } catch (PDOException $ex)
        {
            echo "Connection failed" . "<br>";
            echo $ex->getMessage();
            return;
        }

    }

    public function __construct()
    {
       // $this->connect();
    }

    //add and register a user from the login


    function addUser()
    {

    }


}