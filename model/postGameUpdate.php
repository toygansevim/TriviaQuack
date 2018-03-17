<?php
/**
 * Created by PhpStorm.
 * User: mason
 * Date: 3/15/2018
 * Time: 1:08 PM
 */


//include "../classes/Player.php";
session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

//echo unserialize($_SESSION['user']);

//$member = unserialize($_SESSION['user']);
$member = ($_SESSION['user']);
//serialize($member);

var_dump($member);


$score = $_SESSION['user']->getScore();


//retrieve the user's score
//$score += $_POST['userscore'];

//check whether numeric or not AND DISPLAY
if (!empty($score) && is_numeric($score))
{
    echo "Score :" . $score;
} else
{
    echo "Score is : 0";

}


//$_SESSION['user']->setScore($score);
//$f3->set('score', $score);
