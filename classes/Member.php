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


class Member extends Player
{
    protected $email, $dateJoined, $id;
    protected $friends = array();

    public function __construct($id, $userName, $email, $dateJoined, $score)
    {
        parent::__construct($userName, $score);
        $this->dateJoined = $dateJoined;
        $this->email = $email;
        $this->id = $id;
    }

    //********************************************
    //*********************************************
    //           GETTERS        SETTERS
    //*********************************************
    //*********************************************


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getDateJoined()
    {
        return $this->dateJoined;
    }

    /**
     * @param mixed $dateJoined
     */
    public function setDateJoined($dateJoined)
    {
        $this->dateJoined = $dateJoined;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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

}