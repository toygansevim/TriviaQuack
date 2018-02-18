<?php
/**
 * Created by PhpStorm.
 * User: toygan
 * Date: 2/12/18
 * Time: 11:50 PM
 *
 * This is the Player class that creates
 * a user to play the game
 */


abstract class Player
{
    private $_profileName, $_userName;

    //undefined players can be defined
    private static $_AIcreated = 0;

    /**
     * Player constructor.
     * @param $_profileName
     * @param $_userName
     */
    public function __construct($profileName = "COMPUTER", $userName = "AI ")
    {
        $this->_profileName = $profileName;

        if ($this->_profileName == 'COMPUTER')
        {
            self::$_AIcreated++;
        }
        $this->_userName = $userName . " - " . self::getAIcreated();
    }

    //********************************************
    //*********************************************
    //           METHODS     FUNCTIONS
    //*********************************************
    //*********************************************

    /**
     * @param $profileName
     */
    abstract function sayHi($profileName);

    //********************************************
    //*********************************************
    //           GETTERS        SETTERS
    //*********************************************
    //*********************************************


    /**
     * @return int
     */
    public static function getAIcreated()
    {
        return self::$_AIcreated;
    }

    /**
     * @param int $AIcreated
     */
    public static function setAIcreated($AIcreated)
    {
        self::$_AIcreated = $AIcreated;
    }

    /**
     * @return mixed
     */
    public function getProfileName()
    {
        return $this->_profileName;
    }

    /**
     * @param mixed $profileName
     */
    public function setProfileName($profileName)
    {
        $this->_profileName = $profileName;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->_userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->_userName = $userName;
    }


}