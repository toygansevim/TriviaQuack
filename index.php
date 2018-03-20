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
session_start();


$f3 = Base::instance();


//connect to database
$conn = connect();

$f3->set('DEBUG', 3);
//Define a default route
$f3->route('GET /', function ($f3)
{
    if (loggedIn())
    {
        require 'model/setFatFreeVariables.php';
    }

    $f3->set('title', 'Home Page');
    $f3->set('colorBG', 'primary');
    echo Template::instance()->render('pages/home.html');
});

/**
 * Routes to a login page
 */
$f3->route('GET|POST /login', function ($f3)
{
    require_once 'database/db-functions.php';

    if (loggedIn())
    {
        require 'model/setFatFreeVariables.php';
    }

    //They submitted
    if (isset($_POST['submit']))
    {
        var_dump($_POST);
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
    require_once 'database/db-functions.php';

    if (loggedIn())
    {
        require 'model/setFatFreeVariables.php';
    }

    //They submitted
    if (isset($_POST['submit']))
    {
        //validate the input
        require 'model/validateNewUser.php';
    }
    //route
    echo Template::instance()->render('pages/signup.html');
});


$f3->route('GET|POST /home', function ($f3)
{
    require_once 'database/db-functions.php';
    $member = $_SESSION['user'];

    if (loggedIn())
    {
        require 'model/setFatFreeVariables.php';
    } else
    {
        $f3->reroute('/');
    }
    $members = getLeaders();

    $f3->set('members', $members);
    $f3->set('title', 'Home Page');


    echo Template::instance()->render('pages/game.html'); //script lays under this
});
$f3->route('GET|POST /guest', function ($f3)
{
    require_once 'database/db-functions.php';
    $_SESSION['user'] = retrieveUser("guestAccessKey");
    $f3->reroute('./home');
});
//this route will be displaying the player with the id
$f3->route('GET|POST /profile/@username', function ($f3, $params)
{
    require_once 'database/db-functions.php';

    if (loggedIn())
    {
        require 'model/setFatFreeVariables.php';
    }

    //echo $params['username'];
    //is the username an actual profile?
    if (userExists($params['username']))
    {
        //set the variables needed to display the page

        require 'model/createProfileVariables.php';
        echo Template::instance()->render('pages/profile.html');
        //the  username token was not an actual username
    } else
    {
        //set need variable to display error
        $f3->set('profileUsername', $params['username']);
        echo Template::instance()->render('pages/profileError.html');
    }
});


/**
 * This rerouting function is just so that user's won't get confused with profile routes
 */
$f3->route('GET /profile', function ($f3)
{
    if (loggedIn())
    {
        $f3->reroute('/home');
    }

});


/**
 * This route will allow the user the quit the game safely
 *
 * and will log them out
 */
$f3->route('GET|POST /logout', function ($f3)
{
    //If a logged in user
    if (loggedIn())
    {
        updateMember($f3);
        session_destroy();
        session_unset();
    }
    $f3->reroute('/');
    //logged out

});

//run fat free
$f3->run();