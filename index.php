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
    //They submitted
    if(isset($_POST['submit'])) {

        //validate it
        require 'model/validateReturningUser.php';
    }
    echo Template::instance()->render('pages/login.html');
});

/**
 * Routes to a signup page
 */
$f3->route('GET|POST /signup', function ($f3)
{
    //They submitted
    if(isset($_POST['submit'])) {

        //validate the input
        require 'model/validateNewUser.php';
    }

    //route
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
