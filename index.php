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
require_once("database/db-functions.php");

//create an instance sof the Base class
$f3 = Base::instance();

session_start();

//connect to database
$conn = connect();

$f3->set('DEBUG', 3);

//Define a default route
$f3->route('GET /', function ($f3)
{
    $f3->set('title', 'Home Page');

    $f3->set('colorBG', 'primary');

    echo Template::instance()->render('pages/home.html');
});

/**
 * Routes to a simple table of users
 */
$f3->route('GET|POST /users', function ($f3)
{
    require_once 'database/db-functions.php';

    $members = getLeaders();

    $f3->set('members', $members);

    $f3->set('pageTitle', 'DB');

    echo Template::instance()->render('database/displayDatabase.html');
});

/**
 * Routes to a login page
 */
$f3->route('GET|POST /login', function ($f3)
{
    require 'model/validateReturningUser.php';

    //They submitted
    if(isset($_POST['submit'])) {

        //no errors were developed from validateNewUser.php
        if(empty($errors)) {
            $_SESSION['user'] = retrieveUser($username);

            //reroute to home page of game
            //$f3->reroute("./home");

        } else {
            //store past entries in fat free hive for sticky forms
            $f3->set('username', $username);
            $f3->set('pass', $password);

            //store errors in fat free hive for later use
            $f3->set('username_err', $errors['username_err']);
            $f3->set('pass_err', $errors['pass_err']);
        }
    }

    echo Template::instance()->render('pages/login.html');
});

/**
 * Routes to a signup page
 */
$f3->route('GET|POST /signup', function ($f3)
{
    require 'model/validateNewUser.php';

    //They submitted
    if(isset($_POST['submit'])) {

        //var_dump($GLOBALS);

        //no errors were developed from validateNewUser.php
        if(empty($errors)) {

            //add member to database using db-functions.addMember()
            addMember($username, $password, $email);

            $_SESSION['user'] = retrieveUser($username);

            //reroute to home page of game
            $f3->reroute("./home");

        } else {

            //store past entries in fat free hive for sticky forms
            $f3->set('username', $username);
            $f3->set('email', $email);
            $f3->set('pass', $password);
            $f3->set('repeat_pass', $repeatPassword);

            //store errors in fat free hive for later use
            $f3->set('username_err', $errors['username_err']);
            $f3->set('email_err', $errors['email_err']);
            $f3->set('pass_err', $errors['pass_err']);
            $f3->set('repeat_pass_err', $errors['repeat_pass_err']);
        }
    }

    echo Template::instance()->render('pages/signup.html');
});

$f3->route('GET|POST /home', function ($f3)
{
    require_once 'database/db-functions.php';

    $members = getLeaders();

    $f3->set('members', $members);
    $f3->set('title', 'Home Page');
    echo Template::instance()->render('pages/game.html');

});
/*
//this route will be displaying the player with the id
$f3->route('GET|POST /profiles/@id', function ($f3,$params){

    $id = $params['id'];

    $member = getMember($id);
    $f3->set('member',$member);



});*/
//this route will be displaying the player with the id
$f3->route('GET|POST /profile', function ($f3,$params){
//
//    $id = $params['id'];
//
//    $member = getMember($id);
//    $f3->set('member',$member);



    echo Template::instance()->render('pages/profile.html');
});


//run fat free
$f3->run();
