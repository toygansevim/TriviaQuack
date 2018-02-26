<?php
/**
 * Created by PhpStorm.
 * User: toygan
 * Date: 2/13/18
 * Time: 12:02 AM
 *
 * This class instantiates a database object using Toygan Sevim's cpanel account.
 *
 */

require '/home/tsevimgr/config.php';

try
{
    //instantiate a databse obejct
    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_PERSISTENT, true);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected to database!";


} catch (PDOException $ex)
{
    echo "Connection failed<br>";
    echo $ex->getMessage();
    return;
}
