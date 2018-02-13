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

    //undefined players can be defined
    protected $AIcreated = 0;

    public function __construct($_profileName = "COMP", $_userName = "AI")
    {
        parent::__construct($_profileName, $_userName);

        //work on this
        self::setAIcreated(self::getAIcreated() + 1);

    }

    /**
     * @param $profileName
     */
    function sayHi($profileName)
    {
        echo "<div class='text-danger'>" . $this->getProfileName() . "</div>";

    }
}