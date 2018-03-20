<?php
/**
 * Created by PhpStorm.
 * User: Mason Hernandez
 * Author: Toygan Sevim
 * Date: 3/15/2018
 * Time: 1:08 PM
 */

//needed to be re-included due to ajax access
require_once "../vendor/autoload.php";
require_once "../classes/Player.php";
require_once "../database/db-functions.php";


//needed to be re-started due to ajax access
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

$f3 = Base::instance();
$member = $_SESSION['user'];

$gamesPlayed = 5;

//save user score
$scoreSaved = $_SESSION['user']->getScore();

$questionsArray = [];

//DONT UPDATE GUESTS
if ($member->getUserName() != "Guest")
{
    //retrieve the user played amount
    $amountSaved = $member->getTotalPlayed();

    //Transfer all post elements
    $categorySaved = $member->getCategoryCounts();


    for ($i = 0; $i < 9; $i++)
    {
        $questionsArray[] = $_POST['questioncount'][$i];
    }

}

//get POST values
$amountTotalPlayed = $_POST['totalplayed'];
$score = $_POST['userscore']; //THIS GET SCORE SHOULD BE ADDED
// ONLY ONCE THEREFORE THE MATH BECOMES WRONG. EVEN WITH WRONG ANSWER IT ADDS UP THE OLD VALUE TP
// THE CURRENT ONE DOWN BELOW AND INCREMENTS IT

//check whether numeric or not AND DISPLAY
if (!empty($score) && is_numeric($score))
{
    echo "<p class='float-left text-uppercase text-left mr-3'>Score :" . $score . "</p>";
    echo "<p class='float-right text-right text-success'>" . $_POST['count'] . " / " . " 5 </p>";

} else
{

    echo "<p class='float-left text-uppercase text-left mr-3'>Score is : 0</p>";
    echo "<p class='float-right text-right text-success'>" . $_POST['count'] . " / " . " 5 </p>";

}

//UPDATE POSITION OF THE END
if ($amountTotalPlayed % $gamesPlayed == 0)
{
    //set score of member object
    $_SESSION['user']->setScore($score + $scoreSaved);

    //TOTAL GAME
    if ($member->getUsername() != "Guest")
    {

        $_SESSION['user']->setTotalPlayed($_SESSION['user']->getTotalPlayed() + 5);

        //CATEGORY COUNTS
        $dbString = [];
        $sum;
        for ($i = 0; $i < 9; $i++)
        {
            $sum = (int) $categorySaved[$i]; // database
            $sum += (int) $questionsArray[$i];
            $dbString[] = $sum;
        }

        //set categories played
        $member->setCategoryCounts($dbString);

    }
}

updateMember($f3);
//
/**
 * This function checks the current variable is available to continue
 *
 * @param $variable passed in to be validated
 * @return bool whether it is available or not
 */
function isThere($variable)
{
    return isset($variable) && !empty($variable);
}