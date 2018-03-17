<?php
/**
 * Created by PhpStorm.
 * User: mason
 * Date: 3/15/2018
 * Time: 1:08 PM
 */


require_once("../vendor/autoload.php");
include "../classes/Player.php";
include "../classes/databaseObject.php";
session_start();


error_reporting(E_ALL);
ini_set("display_errors", 1);
//$database = new DatabaseObject();
//$database->connect();

$f3 = Base::instance();


//WITH THE OBJECT
//if ($database->loggedIn())
//{
//    $database->updateMember($f3);
//}

$member = $_SESSION['user'];


echo "<pre>";
var_dump($member);
echo "</pre>";

echo "<pre>";

var_dump($_POST);
echo "</pre>";


//on first hit get the count
$first = true;
$postCountOccured = 0;


$scoreSaved = $_SESSION['user']->getScore();

//retrieve the user's score
//$score = $_POST['userscore'] + $_SESSION['user']->getScore(); //THIS GET SCORE SHOULD BE ADDED


$score = $_POST['userscore']; //THIS GET SCORE SHOULD BE ADDED
// ONLY ONCE THEREFORE THE MATH BECOMES WRONG. EVEN WITH WRONG ANSWER IT ADDS UP THE OLD VALUE TP
// THE CURRENT ONE DOWN BELOW AND INCREMENTS IT


$amountTotalPlayed = $_POST['totalplayed'];


echo "<br><br><pre>";
var_dump($_POST['questioncount'][0]);
echo "</pre>";

$questionsArray = array();
//
//questioncount:
//[     //This is the amount of clicks on the card | HOW MANY TIMES USER PLAYED THE HISTORY
//$codeQuestionCount, $scienceQuestionCount, $artQuestionCount, $historyQuestionCount,
//      $geographyQuestionCount,
//     $celebQuestionCount,
//      $sportsQuestionCount,
//      $randomQuestionCount,
//      $generalCultureQuestionCount;


//Transfer all post elements
for ($i = 0; $i < 10; $i++)
{
    array_push($questionsArray, $_POST['questioncount'][$i]);
}

echo "<br><br><pre>";
print_r($questionsArray);
echo "</pre>";


echo $amountTotalPlayed;


//check whether numeric or not AND DISPLAY
if (!empty($score) && is_numeric($score))
{
    echo "Score :" . $score;
} else
{
    echo "Score is : 0";

}

if ($amountTotalPlayed % 5 == 0) //Every 5th game
{
    $_SESSION['user']->setScore($score + $scoreSaved);
}

$f3->set('score', $score);
$f3->set('toygan', $score);
