<?php
/**
 * Created by PhpStorm.
 *
 * This file's purpose is to update the user's game statistics
 * with every played question game. This way we can track of the points
 * on time.
 * User: toygan
 * Date: 3/15/18
 * Time: 2:51 AM
 */

session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

loggedIn();

