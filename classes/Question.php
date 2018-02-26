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


}