
//checks validation of user while typing
$("#username").focusout(function () {
    $.post('model/validateReturningUser.php',
        {
            fromJS:true,
            username: $(this).val(),
            forusername:true
        }, function (results) {
            $('#username_err').html(results);
        });
});

//checks validation of user while typing
$("#pass").focusout(function () {
    $.post('model/validateReturningUser.php',
        {
            fromJS:true,
            pass: $(this).val(),
            username: $("#username").val(),
            forpass:true
        }, function (results) {
            $('#pass_err').html(results);
        });
});