<?php
/**
 * Created by PhpStorm.
 * User: toygan
 * Date: 2/12/18
 * Time: 11:53 PM
 *
 * This class extends the player class and
 * has an account in the database
 */

/**
 * Class Member
 *
 * Extends player and interacts
 */
class Member extends Player
{
    protected $email, $dateJoined, $id, $totalPlayed;
    protected $categoryCounts = array();
    protected $friends = array();

    /**
     * Member constructor.
     *
     * @param $id
     * @param $userName
     * @param $email
     * @param $dateJoined
     * @param $score
     * @param $totalPlayed
     * @param $categoryCounts
     */
    public function __construct($id, $userName, $email, $dateJoined, $score, $totalPlayed, $categoryCounts)
    {
        parent::__construct($userName, $score);
        $this->dateJoined = $dateJoined;
        $this->email = $email;
        $this->id = $id;
        $this->totalPlayed = $totalPlayed;
        $this->categoryCounts = $categoryCounts;
    }

    //********************************************
    //*********************************************
    //           GETTERS        SETTERS
    //*********************************************
    //*********************************************


    /**
     * Returns email
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * Returns total number of games played
     *
     * @return mixed
     */
    public function getTotalPlayed()
    {
        return $this->totalPlayed;
    }

    /**
     * Sets total number of games played
     *
     * @param mixed $totalPlayed
     */
    public function setTotalPlayed($totalPlayed)
    {
        $this->totalPlayed = $totalPlayed;
    }

    /**
     * Sets total number times played in each catgeory
     *
     * @return mixed
     */
    public function getCategoryCounts()
    {
        return $this->categoryCounts;
    }

    /**
     * Sets total number of games played
     *
     * @param mixed $categoryCounts
     */
    public function setCategoryCounts($categoryCounts)
    {
        $this->categoryCounts = $categoryCounts;
    }


    /**
     * Sets email
     *
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Gets the date joined
     *
     * @return mixed
     */
    public function getDateJoined()
    {
        return $this->dateJoined;
    }

    /**
     * Sets the date joined
     *
     * @param mixed $dateJoined
     */
    public function setDateJoined($dateJoined)
    {
        $this->dateJoined = $dateJoined;
    }

    /**
     * Returns the id of the member
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the id of the member
     *
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Gets the array of friends
     *
     * @return array
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * Sets the array of friends
     *
     * @param array $friends
     */
    public function setFriends($friends)
    {
        $this->friends = $friends;
    }

}