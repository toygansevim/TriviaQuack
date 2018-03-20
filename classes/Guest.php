<?php
/**
 * Created by PhpStorm.
 * User: toygan
 * Date: 2/12/18
 * Time: 11:55 PM
 *
 * This class extends from Player class
 * ready to play however not logged in for features
 */

/**
 * Class Guest
 *
 * This class holds a Guest object which just extends Player
 * and really exists for most readability
 */
class Guest extends Player
{

    /**
     * Guest constructor
     *
     * Passes Username guest and scoire of 0
     */
    public function __construct()
    {
        parent::__construct("Guest", 0);
    }
}