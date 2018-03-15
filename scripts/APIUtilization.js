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
//CATEGORIES FROM THE API
var codeQuestion = 18, scienceQuestion = 17, artQuestion = 25, historyQuestion = 23, geographyQuestion = 22,
    celebQuestion = 26;
var codeQuestionCount, scienceQuestionCount, artQuestionCount, historyQuestionCount, geographyQuestionCount,
    celebQuestionCount;
var generalCultureQuestion = 9, generalCultureQuestionCount;
var sportsQuestion = 21, sportsQuestionCount;
var randomQuestionCount;
var correctAnswer;
var selected;
var waitAseconds = 1000;

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

/**
 * This function is used to pull Json API data from the internet with a given url and parameters.
 * @param amount number of the questions will be displayed
 * @param category Integer number of the API which category of a question you would like
 */
function createQuestion(amount, category) {

    // global difficulty;

    var params = {
        "amount": amount,
        "category": category,
        //Show this to mason
        // "difficulty": !isSet(amount) ? "easy" : amount,
        "difficulty": "easy",
        "type": "multiple"
    };

    var url = 'https://opentdb.com/api.php/';


    //Get the data from JSON API with parameters.
    $.getJSON(url, params, function (result) {
        var items = result.results;


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

            //get a random number between 1 - 4
            // var random = Math.floor(Math.random() * 4 + 1);

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

//On a Tile click, Depending on the Tile that category of a quesiton will be displayed to the user
$(".card").click(function () {

    //Where question gets displayed
    var random;
    var modalBody = $(".answersBody");

    //If it is not showing, THIS IS THE TIME TO SHOW
    if (modalBody.hasClass("d-none")) {
        //remove BS4 class to show
        $(".answersBody").removeClass("d-none");

    } else {
        $(".answersBody").addClass("d-block");
    }

    var cardName1 = $(this).text().trim();

    // COUNT THE AMOUNT OF QUESTION'S CREATED AND WILL CHECK WITH CORRECT ANSWER

    //Depending on the Name of the Tile, pull the JSON file from API
    switch (cardName1) {

        case ("Code"):
            createQuestion(playAGame, codeQuestion);
            codeQuestionCount++;
            break;
        case ("Sports"):
            createQuestion(playAGame, sportsQuestion);
            sportsQuestionCount++;
            break;
        case "Science":
            createQuestion(playAGame, scienceQuestion);
            scienceQuestionCount++;
            break;
        case "Art":
            createQuestion(playAGame, artQuestion);
            artQuestionCount++;
            break;
        case"History":
            createQuestion(playAGame, historyQuestion);
            historyQuestionCount++;
            break;
        case "General Culture":
            createQuestion(playAGame, generalCultureQuestion);
            generalCultureQuestionCount++;
            break;
        case "Celebrities":
            createQuestion(playAGame, celebQuestion);
            celebQuestion++;
            break;
        case "Geography":
            createQuestion(playAGame, geographyQuestion);
            geographyQuestionCount++;

            break;
        case "Random":
            random = Math.floor((Math.random() * 21) + 1);
            createQuestion(playAGame, random); //Generate from an random api number
            randomQuestionCount++;
            break;
        default:
            break;
    }

});

//Answer option on selection Is corresponding color depending on the correct answer + user
$(".answerOption").click(function () {
    selected = $(this);
    selected.addClass("bg-warning").delay(1000).removeClass("bg-dark");

    setTimeout(
        function () {
            //check if the selected one is the correct answer
            if (selected.text() === correctAnswer) {

                selected.addClass("bg-success").removeClass("bg-warning");
                console.log(selected.siblings());


                selected.siblings().addClass("bg-danger");
                //Next question should be displayed automatically

                //increment the counter of the player object here


                //increment the amount of played question's here


            }
            else {

                //THIS ELSE PART IS OPEN TO CHANGE / I CAN JUST HIGHLIGHT THE CORRECT ANSWER AND BE DONE

                selected.addClass("bg-danger").removeClass("bg-warning");

                console.log("selected" + selected.siblings());

                for (var i = 1; i < selected.siblings().length + 1; i++) {

                    if ($("#answer" + i).text() === correctAnswer) {
                        $("#answer" + i).addClass("bg-success");
                        $("#answer" + i).siblings().addClass("bg-danger");
                    }

                    else {
                        console.log(i + " was that.");

                        $("#answer" + i).addClass("bg-danger");
                    }
                }
                //Add green to the correct answer


            }

            // alert(correctAnswer);
            // alert(selected.id);
        },
        2000);


    setTimeout(resetButtonColors, 5000);

    //move to the next question


});

/**
 * This function will reset the button's for the next question
 */
function resetButtonColors() {
    $(".answerOption").addClass("bg-dark");

    if ($(".btn").hasClass("bg-success")) {
        $(".btn").removeClass("bg-success");
    } else if ($(".btn").hasClass("bg-danger")) {
        $(".btn").removeClass("bg-danger");
    }


}

function correctAnswer() {

}