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

    /**
     * Player constructor.
     * @param $_profileName
     * @param $_userName
     */
    public function __construct($_profileName, $_userName)
    {
        $this->_profileName = $_profileName;
        $this->_userName = $_userName;
    }


    //********************************************
    //*********************************************
    //           GETTERS        SETTERS
    //*********************************************
    //*********************************************

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