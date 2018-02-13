<?php

/**
 * Toygan Sevim
 *
 * index.php
 *
 * This is where the fatfree will be created and
 * used to route our directories and classes to the users
 */
error_reporting(E_ALL);
ini_set("display_errors", TRUE);

require_once("vendor/autoload.php");

//create an instance sof the Base class
$f3 = Base::instance();

//Define a default route
$f3->route('GET /', function ()
{
    echo Template::instance()->render('pages/home.html');
});

//run fat free
$f3->run();
