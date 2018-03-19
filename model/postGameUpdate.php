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


$gamesPlayed = 5;


echo "<pre>";
//var_dump($_POST);
echo "</pre>";
echo "<pre>";
var_dump($member);
echo "</pre>";


//on first hit get the count
$first = true;
$postCountOccured = 0;

$scoreSaved = $_SESSION['user']->getScore();

//NOT SOMETHING THAT EFFECT
if (notMember($member))
{
    $amountSaved = $_SESSION['user']->getTotalPlayed();//retrieve the user played amount
} else
{
    echo "MEMBER ELSE HERE!";
}


echo "TOTAL PLAYED AT THIS MOMENT IS : " . $amountSaved;

$score = $_POST['userscore']; //THIS GET SCORE SHOULD BE ADDED
// ONLY ONCE THEREFORE THE MATH BECOMES WRONG. EVEN WITH WRONG ANSWER IT ADDS UP THE OLD VALUE TP
// THE CURRENT ONE DOWN BELOW AND INCREMENTS IT

$amountTotalPlayed = $_POST['totalplayed'];


//var_dump($questionCountString);


$questionsArray = array();

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

$playedOnce = true;

//UPDATE POSITION OF THE END
if ($amountTotalPlayed % $gamesPlayed == 0) //Every 5th game //can be changed
{
    if ($playedOnce)
    {

        //SCORE
        $_SESSION['user']->setScore($score + $scoreSaved);

        //TOTAL GAME
        if (notMember($member))
        {

            $_SESSION['user']->setTotalPlayed($_SESSION['user']->getTotalPlayed() + 5);

            //CATEGORY COUNTS

            setCategoryString();

            var_dump($questionCountString);

            $_SESSION['user']->setCategoryCounts($questionCountString);

        }
    }

    $playedOnce = false;

}

function setCategoryString()
{
    $questionCountString = implode(',', $_POST['questioncount']);


}

function notMember($member)
{
    return !$member->getUserName() == "Guest" || !$member->getUserName() == "GUEST";
}

function isThere($variable)
{
    return isset($variable) && !empty($variable);
}

$f3->set('score', $score);
