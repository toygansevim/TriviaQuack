<?php
/**
 * Created by PhpStorm.
 *
 * This file's purpose is to update the user's game statistics
 * with every played question game. This way we can track of the points
 * on time.
 * User: toygan
 * Date: 3/15/18
 * Time: 2:51 AM
 */

session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

include "../classes/Player.php";
require_once '../database/db-functions.php';


if (isset($_SESSION))
{
    if (isset($_SESSION['user']) && !empty($_SESSION['user']))
    {

        // updateUserScore();
        print_r($_SESSION['user']);


    }
}
//
//
echo "<pre>";
print_r($_POST);
echo "</pre>";

//retrieve the user's score
$score = $_POST['userscore'];

//check whether numeric or not AND DISPLAY
if (!empty($score) && is_numeric($score))
{
    echo "Score :" . $score;
} else
{
    echo "Score is : 0";

}