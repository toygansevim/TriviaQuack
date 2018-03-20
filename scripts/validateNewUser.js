
//checks validation of user while typing
$("#username").focusout(function () {
    $.post('model/validateNewUser.php',
        {
            fromJS:true,
            username: $(this).val(),
            forusername:true
        }, function (results) {
            $('#username_err').html(results);
        });
});

//checks validation of user while typing
$("#email").focusout(function () {
    $.post('model/validateNewUser.php',
        {
            fromJS:true,
            email: $(this).val(),
            foremail:true
        }, function (results) {
            $('#email_err').html(results);
        });
});

//checks validation of user while typing
$("#pass").focusout(function () {
    $.post('model/validateNewUser.php',
        {
            fromJS:true,
            pass: $(this).val(),
            forpass:true
        }, function (results) {
            $('#pass_err').html(results);
        });
});

//checks validation of user while typing
$("#repeat-pass").focusout(function () {
    $.post('model/validateNewUser.php',
        {
            fromJS:true,
            'repeat-pass': $(this).val(),
            pass:$("#pass").val(),
            forrepeatpass:true
        }, function (results) {
            $('#repeat_pass_err').html(results);
        });
});