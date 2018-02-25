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

session_start();


//create an instance sof the Base class
$f3 = Base::instance();

$f3->set('DEBUG',3);

//Define a default route
$f3->route('GET /', function ($f3)
{
    $f3->set('title','Home Page');

    $f3->set('colorBG','primary');

    echo Template::instance()->render('pages/home.html');
});

$f3->route('GET|POST /users', function ($f3){

    require_once 'database/basicSetting.php';

   // echo print_r($fieldsArray);
    echo "TOYGAN";

    $f3->set('pageTitle','TESTING DATABASE');

    echo Template::instance()->render('database/displayDatabase.html');
});

$f3->route('GET|POST /login', function ($f3){

    echo Template::instance()->render('pages/login.html');
});

$f3->route('GET|POST /signup', function ($f3){

    echo Template::instance()->render('pages/signup.html');
});


//run fat free
$f3->run();
