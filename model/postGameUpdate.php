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

$f3 = Base::instance();

$member = $_SESSION['user'];

$gamesPlayed = 5;

//save user score
$scoreSaved = $_SESSION['user']->getScore();


$questionsArray = array();

//DONT UPDATE GUESTS
if ($member->getUserName() != "Guest")
{
    $amountSaved = $member->getTotalPlayed();//retrieve the user played amount
    //Transfer all post elements

    $categorySaved = $member->getCategoryCounts();

    //    var_dump($_POST['questioncount']);

    echo "<br>";

    for ($i = 0; $i < 9; $i++)
    {
        $questionsArray[] = $_POST['questioncount'][$i];
    }

    //    var_dump($questionsArray);
}


//echo "TOTAL PLAYED AT THIS MOMENT IS : " . isThere($amountSaved) ? $amountSaved : " still 0";

//get POST values
$amountTotalPlayed = $_POST['totalplayed'];
$score = $_POST['userscore']; //THIS GET SCORE SHOULD BE ADDED
// ONLY ONCE THEREFORE THE MATH BECOMES WRONG. EVEN WITH WRONG ANSWER IT ADDS UP THE OLD VALUE TP
// THE CURRENT ONE DOWN BELOW AND INCREMENTS IT


//questioncount:
//[     //This is the amount of clicks on the card | HOW MANY TIMES USER PLAYED THE HISTORY
//$codeQuestionCount, $scienceQuestionCount, $artQuestionCount, $historyQuestionCount,
//      $geographyQuestionCount,
//     $celebQuestionCount,
//      $sportsQuestionCount,
//      $randomQuestionCount,
//      $generalCultureQuestionCount;


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
if ($amountTotalPlayed % $gamesPlayed == 0) //Every 5th game //can be changed
{

    //SCORE
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


        //$_SESSION['user']->setCategoryCounts($questionCountString);

        //        var_dump($dbString);

        $member->setCategoryCounts($dbString);

    }
}

//$f3->set('score', $score);

function setCategoryString($questionCountString)
{
    $questionCountString = implode(',', $_POST['questioncount']);


    //return
}

/**
 * This function checks the current variable is available to continue
 * @param $variable passed in to be validated
 * @return bool whether it is available or not
 */
function isThere($variable)
{
    return isset($variable) && !empty($variable);
}
