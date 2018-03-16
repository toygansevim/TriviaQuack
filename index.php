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
    require_once 'database/db-functions.php';

    if (loggedIn()) updateMember();

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
    require_once 'database/db-functions.php';

    if (loggedIn()) updateMember($f3);

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

    if (loggedIn()) updateMember($f3);
    else $f3->reroute('/');

    $members = getLeaders();

    $f3->set('members', $members);
    $f3->set('title', 'Home Page');

    var_dump($_SESSION['user']);

    echo Template::instance()->render('pages/game.html');
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

    //THIS PART NEEDS HELP PLEASE MASON BRAIN STORMING REQUIRED


    $username = $params['username'];

    $onlineMember = $_SESSION['user'];

    echo "<pre>";
    var_dump($onlineMember);
    echo "</pre>";

    $member = retrieveUserProfile($username);


    $f3->set('member', $member);

    //set the elements of the page depending on the username, if the username and the online's
    // match take action as it was their profile

    //we should be able to check if the current and the page viewed are different or same
    //    $f3->set('score', $onlineMember->getScore());

    //this can be retrieved in the page too

    echo Template::instance()->render('pages/profile.html');
});


//this route will be displaying the player with the id
$f3->route('GET|POST /profile', function ($f3, $params)
{
    echo Template::instance()->render('pages/profile.html');
});

//run fat free
$f3->run();