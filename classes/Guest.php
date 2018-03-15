<?php
/**
 * Created by PhpStorm.
 * User: toygan
 * Date: 2/12/18
 * Time: 11:55 PM
 *
 * This class extends from Player class
 * ready to play however not logged in for features
 *
 */

class Guest extends Player
{
    public function __construct($_userName)
    {
        parent::__construct("Guest", 0);
        //work on this
        //self::setAIcreated(self::getAIcreated() + 1);
    }
}