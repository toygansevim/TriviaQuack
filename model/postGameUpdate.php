<?php
/**
 * Created by PhpStorm.
 * User: mason
 * Date: 3/15/2018
 * Time: 1:08 PM
 */
$score = $_SESSION['user']->getScore();
$score += $_POST['gameScore'];
$_SESSION['user']->setScore($score);
$f3->set('score', $score);