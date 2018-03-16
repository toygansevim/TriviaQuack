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


$f3->set('username', $_SESSION['user']->getUsername());
$f3->set('score', $_SESSION['user']->getScore());

?>