# TriviaQuack
This is the Final project for IT-328 Full Stack Development. 

This is a trivia question based small browser game that is available for all displays.

@author Toygan Sevim
@author Mason Hernandez

From the beginning of the TriviaQuack we have clearly stated our git commit messages with breif descriptions about the topic 
and the details of code alterations.

Fat Free Framework is used to create routes and seperation of the View, Controller, and the Model.
Template's of views were generated by the Fat Free Framework. Routes designated to improve usability.

Created prepared statements to call function's with different variables can be passed in to work for altering user contributions. User can alter their data by playing more games and updating their score.User's are allowed to alter their data. Data gets updated as they play more and the user's can not be deleted however they can not delete their account from the database.

Object Oriented Programming is defined between class hierarchy which includes a parent and to child classes that supports our user objects that plays the game. One object being the guest where they are not required to sign in. The other for registered member's which allow's multiple functionalities.

Full Docblocks are provided for PHP. Code is well commented through out the site. Seperation of the MVC helped clear coding and commenting for the project.

Validation on both client side and server side occurs as the players attend to become a user and enter values to the site.

User input's are completely validated on client side with Javascript and server side validation is being checked by PHP.

TriviaQuack incorporates Jquery and Ajax to create functionality on the client side. Ajax functions are also used with Json requests for the API utilization. More javascript and Jquery functions are used through-out the site to adjust classes. Change colors, revert changes, update members.

API Utilization takes place in TriviaQuack where player's are able to choose from 8 different game category options or they are allowed to choose a random question which also generated by the API. Questions are pulled directly as the request occurs therefore speed issues may occur as question requests occur.
URL: https://opentdb.com/api.php | Parameters of the API are retrieved from user by event handlers.
