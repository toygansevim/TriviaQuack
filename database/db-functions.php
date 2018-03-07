<?php
/**
 * Created by PhpStorm.
 * User: toygan
 * Date: 2/26/18
 * Time: 2:03 AM
 */


//needed config file
include("/home/tsevimgr/config.php");

//connection method
function connect()
{
    try
    {
        //instantiate a databse obejct
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_PERSISTENT, true);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       // echo "Connected to database for Trivia quack!";
        //return connection
        return $conn;

    } catch (PDOException $ex)
    {
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
    $sql = "SELECT id,username,totalScore FROM triviaMembers ORDER BY id";

    //prepare

    $statement = $conn->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;

}


function addMember($username, $PASSWORD, $emailAddress,
                   $firstName, $lastName, $totalScore,
                   $joinDate, $gender, $quackMember)
{

    global $conn;

    //define
    $sql = "INSERT INTO triviaMembers (username, PASSWORD, emailAddress, firstName, lastName, totalScore,
joinDate, gender, quackMember) VALUES(:username, :PASSWORD, :emailAddress, :firstname, :lastName,
 :ttalScoreo,:joinDate,:gender,:quackMember)";


}