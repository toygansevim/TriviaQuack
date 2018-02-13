<?php

/**
 * Toygan Sevim
 *
 * index.php
 *
 * This is where the fatfree will be created and
 * used to route our directories and classes to the users
 */
session_start();


error_reporting(E_ALL);
ini_set("display_errors", TRUE);

require_once("vendor/autoload.php");

//create an instance sof the Base class
$f3 = Base::instance();

$f3->set('DEBUG',3);


//Define a default route
$f3->route('GET /', function ($f3)
{
    $f3->set('title','Home Page');

    $color = "";
    $guest = new Guest();
    $guest->sayHi("toygan");

    $f3->set('colorBG','warning');


    echo Template::instance()->render('pages/home.html');
});

$f3->route('GET /database',function($f3)
{
    $f3->set('pageTitle','TESTING');

    echo Template::instance()->render('database/basicSetting.php');

});

//run fat free
$f3->run();
