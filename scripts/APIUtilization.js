"use strict";

$('#result').hide();

//Define api key
// var key = 'cIsZWPaZ1zCG8ACTRXcmN1SM70CRrqX62xjXG18D';


$("#btnGo").on('click', function () {
    $('#result').html("<option>--Select--</option>");
    var search = $('#enterFood').val();

    var params = {
        "format": "json",
        "q": search,
        "sort": "n",
        "max": 25,
        "offset": 0,
        "api_key": key
    };

    var url = 'https://opentdb.com/api.php';

    //Get the data
    $.getJSON(url, params, function (result) {
        var items = result.data[0];

        $.each(items, function (index, item) {
            // $('#result').append("<option value='" + item.ndbno + "'>" + item.name + "</option>");
            $("#details").append("<p>"+</p>");
            $("#details").append(index);

        });

    });

    $('#result').show();

    //create alert from option value
    // $('#result').on('change', function () {
    //     var ndbno = $(this).val();
    //
    //     //get the parameters
    //     var params = {
    //         "amount": 5,
    //         "category": 21,
    //         "difficulty": "easy",
    //         "type": "multiple"
    //     };
    //
    //     var url = 'https://api.nal.usda.gov/ndb/V2/reports';
    //
    //     //Get the data
    //     $.getJSON(url, params, function (result) {
    //         var nutrients = result.data[0].category;
    ////         var ingredients = result.foods[0].food.ing;
    //
    //         $('#details').html("<h3>Nutrients</h3>");
    //
    //     });
    // });
});


