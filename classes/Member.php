<?php
/**
 * Created by PhpStorm.
 * User: toygan
 * Date: 2/12/18
 * Time: 11:53 PM
 *
 * This class extends the player class and
 * has an account in the database
 *
 */


class Member
{
    protected $userName, $profileName, $loginStreak, $points;
    protected $friends = array();

    public static $AIcreated = 0;


    public function __construct($username = "AI")
    {

        $this->userName = "AI - " . self::getAIcreated();

        //if default user created, assign computer name and
        if ($username == "AI")
        {
            self::setAIcreated(self::getAIcreated() + 1);
        }
    }


    //********************************************
    //*********************************************
    //           METHODS     FUNCTIONS
    //*********************************************
    //*********************************************

    function sayHi($profileName)
    {
        echo "<p class='text-primary'>" . $this->userName . " HEllO THERE HI...";
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
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getProfileName()
    {
        return $this->profileName;
    }

    /**
     * @param mixed $profileName
     */
    public function setProfileName($profileName)
    {
        $this->profileName = $profileName;
    }

    /**
     * @return mixed
     */
    public function getLoginStreak()
    {
        return $this->loginStreak;
    }

    /**
     * @param mixed $loginStreak
     */
    public function setLoginStreak($loginStreak)
    {
        $this->loginStreak = $loginStreak;
    }

    /**
     * @return mixed
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param mixed $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

    /**
     * @return array
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * @param array $friends
     */
    public function setFriends($friends)
    {
        $this->friends = $friends;
    }

    /**
     * @return int
     */
    public static function getAIcreated()
    {
        return self::$AIcreated;
    }

    /**
     * @param int $AIcreated
     */
    public static function setAIcreated($AIcreated)
    {
        self::$AIcreated = $AIcreated;
    }


}