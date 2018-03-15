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
    private $_userName, $_score;

    /**
     * Player constructor.
     * @param $_profileName
     * @param $_userName
     */
    public function __construct($userName, $score)
    {
        $this->_userName = $userName;
        $this->_score = $score;
    }

    //********************************************
    //*********************************************
    //           GETTERS        SETTERS
    //*********************************************
    //*********************************************

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

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->_score;
    }

    /**
     * @param mixed $score
     */
    public function setScore($score)
    {
        $this->_score = $score;
    }


}