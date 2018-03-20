"use strict";
/**
 *
 * APIUtilization.js
 * This script will use opentdb's website url to generate JSON files on Tile selections on the /Home route
 * while the user is playing the game
 * @type {number}
 * @author Toygan Sevim
 * @version 1.0
 */

//to play the game with 1 question, amount can be set as default final 1, since in every click new question
var playAGame = 1;
//Scored in game session
var scored = 0;

//CATEGORIES FROM THE API
var codeQuestion = 18, scienceQuestion = 17, artQuestion = 25, historyQuestion = 23, geographyQuestion = 22,
    celebQuestion = 26;
var generalCultureQuestion = 9, generalCultureQuestionCount = 0;
var sportsQuestion = 21, sportsQuestionCount = 0;
var codeQuestionCount = 0, scienceQuestionCount = 0, artQuestionCount = 0, historyQuestionCount = 0,
    geographyQuestionCount = 0,
    celebQuestionCount = 0;
var randomQuestionCount = 0;
var lastSelected;


var correctAnswer = 0;
var selected;
var waitAseconds = 1000;
var questionsMaxPlay = 5;
var playerScore = 0, totalPlayedCount = 0, correctAnswerCount = 0;

//times played
var count = 0;

/**
 * This function will shuffle the given array elements and will return a shuffled array
 * @param arrayList the array that user would like to shuffle
 */
function shuffle(arrayList) {
    var j, x, i;
    for (i = arrayList.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = arrayList[i];
        arrayList[i] = arrayList[j];
        arrayList[j] = x;
    }
}

//THIS IS THE AJAX FUNCTION THAT UPDATES USER OBJECT
function updateScore() {

    var score = getResults();

    $.post("model/postGameUpdate.php", {
            userscore: score,
            questioncount: [     //This is the amount of clicks on the card | HOW MANY TIMES USER PLAYED THE HISTORY
                scienceQuestionCount,
                codeQuestionCount,
                sportsQuestionCount,
                artQuestionCount,
                randomQuestionCount,
                historyQuestionCount,
                geographyQuestionCount,
                generalCultureQuestionCount,
                celebQuestionCount
            ],
            totalplayed: totalPlayedCount,
            correctanswer: correctAnswerCount,
            count: count

        },
        function (result) {
            console.log(result);

            $("#score").html(result);

        }
    );
}


//DIFFICULTY OPTIONS
var options = ["easy", "medium", "hard"];

/**
 * This function sets the difficulty of the question to a different result every time
 * @param options difficulty options
 * @returns {*} a difficulty easy, meduim, or hard
 */
function setDifficulty(options) {

    var select = Math.floor(Math.random() * 3);

    if (select == 0) {
        console.log("OPTION IS:   " + options[0]);
        return options[0];
    }
    else if (select == 1) {
        console.log("OPTION IS:   " + options[1]);

        return options[1];
    }
    else {
        console.log("OPTION IS:   " + options[2]);
        return options[2];
    }

}


/**
 * This function is used to pull Json API data from the internet with a given url and parameters.
 * @param amount number of the questions will be displayed
 * @param category Integer number of the API which category of a question you would like
 */
function createQuestion(amount, category) {


    //EVERY QUIZ CREATION WILL INCREMENT THE VALUES OF PLAYING THE GAME


    // global difficulty;
    var params = {
        "amount": amount,
        "category": category,
        //Show this to mason
        // "difficulty": !isSet(amount) ? "easy" : amount,
        "difficulty": setDifficulty(options),
        "type": "multiple"
    };

    //URL API
    var url = 'https://opentdb.com/api.php/';


    //Get the data from JSON API with parameters.
    $.getJSON(url, params, function (result) {
        var items = result.results;
        //WE CAN SET DATA HERE MASON ??? AFTER EVERY JSON LOAD

        //choose all options and arrange them
        $.each(items, function (index, item) {

            //get the elements and set to variables
            var randomCreatedArray;
            var answersDataArray;
            var questionName = $("#celebritiesModalLabel");
            var answer1 = $("#answer1");
            var answer2 = $("#answer2");
            var answer3 = $("#answer3");
            var answer4 = $("#answer4");

            //get the data
            var questionData = item.question;

            correctAnswer = item.correct_answer;
            answersDataArray = [item.incorrect_answers[0], item.incorrect_answers[1], item.incorrect_answers[2], correctAnswer];

            shuffle(answersDataArray);

            randomCreatedArray = [];

            //set the question H3 to the data from file
            questionName.html(questionData);

            //load the buttons
            for (var i = 1; i <= answersDataArray.length; i++) {
                //in this line hopefully I will create What I want
                //To the random selection occurance array will take the values with .push
                //we will push in every element that has an Answer ID !! will increment the position with the loop
                //also will change the text value of the button to the array position
                randomCreatedArray.push($("#answer" + i).html(answersDataArray[i - 1]));
            }

        });
    });

}

$(".answerOption").on('click', getQuestion);

//On a Tile click, Depending on the Tile that category of a quesiton will be displayed to the user
$(".card").on('click', getModalQuestion);

/**
 * This function will reset the button's for the next question
 */
function resetButtonColors() {
    //selected button
    $(".answerOption").addClass("bg-dark");

    //if had color green clear
    if ($(".btn").hasClass("bg-success")) {
        $(".btn").removeClass("bg-success");
    }
    if ($(".btn").hasClass("bg-danger")) {
        //clear
        $(".btn").removeClass("bg-danger");
    }

}

function getModalQuestion() {

    //Where question gets displayed
    var modalBody = $(".answersBody");

    console.log("on card click last selected is = " + lastSelected);

    //If it is not showing, THIS IS THE TIME TO SHOW
    if (modalBody.hasClass("d-none")) {
        //remove BS4 class to showOSHA shipped to submit the the
        $(".answersBody").removeClass("d-none");

    } else {
        $(".answersBody").addClass("d-block");
    }

    //Get the card name for game
    var cardName1 = $(this).text().trim();

    // COUNT THE AMOUNT OF QUESTION'S CREATED AND WILL CHECK WITH CORRECT ANSWER

    //Depending on the Name of the Tile, pull the JSON file from API
    switch (cardName1) {

        case "Code":
            lastSelected = "codeQuestion";
            console.log("AT THE END last selected is = " + lastSelected);
            createCodeQuestion();
            break;
        case "Sports":
            createSportsQuestion();
            break;
        case "Science":
            createScienceQuestion();
            break;
        case "Art":
            createArtQuestion();
            break;
        case"History":
            createHistoryQuestion();
            break;
        case "General Culture":
            lastSelected = "generalCultureQuestion";
            console.log("AT THE END last selected is = " + lastSelected);
            createGeneralQuestion();
            break;
        case "Celebrities":
            createCelebQuestion();
            break;
        case "Geography":
            createGeoQuestion();
            break;
        case "Random":
            createRandomQuestion();
            break;
        default:
            break;
    }
}

function getQuestion() {

    // $(".answerOption").off();

//start counting the round
    count++;

//get the button selected
    selected = $(this);

    //unbind the mouse for other clicks
    //$(".answerOption").unbind();

    selected.addClass("bg-warning").delay(1000).removeClass("bg-dark");
    //
    // $(".answerOption").on('click', function () {
    //     alert("here");
    //     $(this).bind();
    //     $(this).siblings().bind();
    // });

    //give some time to show the answer  2000 => 2 seconds
    setTimeout(
        function () {
            //check if the selected one is the correct answer
            if (selected.text() === correctAnswer) {

                selected.addClass("bg-success").removeClass("bg-warning");

                selected.siblings().addClass("bg-danger").removeClass("bg-dark");

                //increment the  counter of the player object here
                correctAnswerCount++;


            }
            else {
                //THIS ELSE PART IS OPEN TO CHANGE / I CAN JUST HIGHLIGHT THE CORRECT ANSWER AND BE DONE
                selected.addClass("bg-danger").removeClass("bg-warning");
                for (var i = 1; i <= questionsMaxPlay - 1; i++) {

                    if ($("#answer" + i).text() === correctAnswer) {
                        $("#answer" + i).addClass("bg-success").removeClass("bg-dark");

                        console.log($("#answer" + i).text() + " Was the correct answer, for curious people...");
                    }
                }
            }

            //increment the amount of played question's here
            totalPlayedCount++;
        },
        1000);

    //move to the next question

    setTimeout(function () {
        $(".answersBody").addClass("bg-none");
    }, 1600);

    setTimeout(function () {
        $(".answersBody").removeClass("bg-none");

        //THIS IS WHERE THE MODAL FINDS THE LAST PLAYED QUESTION AND REPLAYS IT
        if (count % questionsMaxPlay == 0) {
            updateScore();
            count = 0;

            //exit out of the modal
            location.reload();
            location.reload();

            //reload the page twice
        }
        else {
            //COUNTING THE INNER MODAL AMOUNG HAS TO OCCUR HERE
            updateScore();
        }


        createQuestion(playAGame, lastSelected);
        resetButtonColors();


    }, 2300);

}

/**
 * This function will calculate the total
 * @param correctAnswerCount
 * @param playerScore
 * @returns {number|*}
 */
function totalScoreCalculation(correctAnswerCount) {

    var pointAmount = 100;
    //how many they played
    playerScore = correctAnswerCount * pointAmount;
    return playerScore;
}


/**
 * This method will get the totalScore calculated from the quiz (5 questions / or unless they quit
 * @returns {number}
 */
function getResults() {

    scored = totalScoreCalculation(correctAnswerCount);

    console.log(scored); // info purpose

    return scored;

}


/*
//#####
//  CREATE A QUESTION BELOW AND ARRANGE BUTTON'S
//#####
//      BELOW FUNCTIONS WILL CREATE A QUESTION BASED AND INCREMENT THE CREATED QUESTION BY 1
 */
function createCodeQuestion() {
    resetButtonColors();
    lastSelected = codeQuestion;
    codeQuestionCount++;
    createQuestion(playAGame, codeQuestion);
}

function createSportsQuestion() {
    resetButtonColors();
    lastSelected = sportsQuestion;
    sportsQuestionCount++;
    // alert(sportsQuestionCount);
    createQuestion(playAGame, sportsQuestion);
}

function createScienceQuestion() {
    resetButtonColors();
    lastSelected = scienceQuestion;
    scienceQuestionCount++;
    createQuestion(playAGame, lastSelected);


}

function createArtQuestion() {
    resetButtonColors();
    lastSelected = artQuestion;
    artQuestionCount++;
    createQuestion(playAGame, artQuestion);

}

function createHistoryQuestion() {
    resetButtonColors();
    lastSelected = historyQuestion;
    historyQuestionCount++;
    createQuestion(playAGame, historyQuestion);

}

function createGeneralQuestion() {
    resetButtonColors();
    lastSelected = generalCultureQuestion;
    generalCultureQuestionCount++;
    createQuestion(playAGame, generalCultureQuestion);

}

function createCelebQuestion() {
    resetButtonColors();
    lastSelected = celebQuestion;
    createQuestion(playAGame, celebQuestion);
    celebQuestionCount++;
}

function createGeoQuestion() {
    resetButtonColors();
    lastSelected = geographyQuestion;
    createQuestion(playAGame, geographyQuestion);
    geographyQuestionCount++;

}

function createRandomQuestion() {
    var random;
    resetButtonColors();
    random = Math.floor(Math.random() * 21 + 1);
    createQuestion(playAGame, random); //Generate from an random api number
    randomQuestionCount++;
}
