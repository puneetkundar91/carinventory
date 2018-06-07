function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    } else {
        return false;
    }
}

$(document).ready(function(){
    $("#btnLoginUser").click(function(e){
        e.preventDefault();
        var username = $("#email").val();
        var pwd = $("#pwd").val();

        if (username != "" && pwd != "") {

            if (validateEmail(username)) {
                $.ajax({
                    "url": urlpath + "action/actionLogin.php",
                    "type": "POST",
                    "async": false,
                    "data": {
                        username: username,
                        pwd: pwd
                    },
                    "success": function (data) {
                        var data = JSON.parse(data);
                        if (data.status == "success") {
                            window.location.href = urlpath+"models.php";
                        } else {
                            alert(data.msg)
                        }
                    }
                });
            } else {
                alert('Invalid Email Address');
            }
        } else {
            alert("Fill all details");
        }
    });
});


