<?php
/**
 * @author Mason Hernanadez
 * filename: setFatFreeVariables.php
 * condition: functioning/complete
 *
 * This file updates fat free variables
 * so they can be used in the web page
 *
 */

//if ($_SESSION['user']->getUsername() == "Guest") {
//    $f3->set('isGuest',true);
//}

$f3->set('username', $_SESSION['user']->getUsername());

$f3->set('score', $_SESSION['user']->getScore());

$f3->set('navStats', $_SESSION['user']->getScore().' | '.$_SESSION['user']->getUsername());

