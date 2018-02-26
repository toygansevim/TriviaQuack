<?php
/**
 * Created by PhpStorm.
 * User: toygan
 * Date: 2/26/18
 * Time: 1:12 AM
 */

class Question
{
    private $_question, $_answer, $_difficulty, $_point, $_category;
    private $_answersArray = [];
    private $_categories = array("history", "science", "art", "sports", "code", "celebrities", "generalCulture", "geography");


    /**
     * Question constructor.
     * @param $question
     * @param $answer
     * @param $difficulty
     * @param $point
     * @param $category
     */
    public function __construct($question, $answer, $difficulty, $point, $category, $answersArray)
    {
        $this->_question = $question;
        $this->_answer = $answer;
        $this->_difficulty = $difficulty;
        $this->_point = $point;
        $this->_category = $category;
        $this->_answersArray = $answersArray;
    }


    //********************************************
    //*********************************************
    //           METHODS     FUNCTIONS
    //*********************************************
    //*********************************************

    //sets a random diff to the question
    /**
     * @throws Exception
     */
    function pickDifficulty()
    {
        $random = random_int(1, 6);
        Question::setDifficulty($random);

        echo Question::getDifficulty();
        echo $random;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "Question :" . $this->getQuestion();
    }



    //********************************************
    //*********************************************
    //           GETTERS        SETTERS
    //*********************************************
    //*********************************************


    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->_question;
    }

    /**
     * @param mixed $question
     */
    public function setQuestion($question)
    {
        $this->_question = $question;
    }

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->_answer;
    }

    /**
     * @param mixed $answer
     */
    public function setAnswer($answer)
    {
        $this->_answer = $answer;
    }

    /**
     * @return mixed
     */
    public function getDifficulty()
    {
        return $this->_difficulty;
    }

    /**
     * @param mixed $difficulty
     */
    public function setDifficulty($difficulty)
    {
        $this->_difficulty = $difficulty;
    }

    /**
     * @return mixed
     */
    public function getPoint()
    {
        return $this->_point;
    }

    /**
     * @param mixed $point
     */
    public function setPoint($point)
    {
        $this->_point = $point;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->_category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->_category = $category;
    }

    /**
     * @return array
     */
    public function getAnswersArray()
    {
        return $this->_answersArray;
    }

    /**
     * @param array $answersArray
     */
    public function setAnswersArray($answersArray)
    {
        $this->_answersArray = $answersArray;
    }

}