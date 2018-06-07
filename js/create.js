$(document).ready(function(){
    $("body").on("change", "#uploadProfileImg", function (e) {
        var el = $(this);
        var file = this.files[0];
        var size = this.files[0].size;
        if (size > 2 * 1024 * 1024) {
            alert("Too large Image. Only image smaller than 2MB can be uploaded.");
        } else {
            var form = new FormData();
            form.append("image", file);
            $.ajax({
                url: urlpath + "action/uploadImg.php",
                type: "POST",
                cache: false,
                contentType: false, // important
                processData: false, // important
                data: form,
                success: function (data) {
                    var data = JSON.parse(data);
                    if (data.status == "success") {
                        el.closest('.form-group').find('.locationImgView').attr("src", urlpath + "upload/" + data.msg);
                    } else {
                        alert(data.msg)
                    }
                }
            });
        }
    });
    
    $(".checkNumber").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                $("#errmsg").html("Digits Only").show().fadeOut("slow");
                return false;
            }
        });
        
        $('.checkNumber').bind("cut copy paste drop", function (e) {
            e.preventDefault();
        });
    
    $("#createModel").click(function(e){
        e.preventDefault();
        var modelYear =  $("#modelYear").val();
        var modelColor =  $("#modelColor").val();
        var profileImg =  $("#profileImg").attr("src");
        var manufacturerName =  $("#manufacturerName").val();
        var modelRegistrn =  $("#modelRegistrn").val();
        var modelQuantity = $("#modelQuantity").val();
        var modelName =  $("#modelName").val();
        
        if(modelRegistrn != "" && modelName != ""  && modelYear != ""  && modelColor != ""  && profileImg != ""  && manufacturerName != "" && modelQuantity != "" ){
            $.ajax({
                "url": urlpath + "action/actionCreateModel.php",
                "type": "POST",
                "async": false,
                "data": {
                    modelName: modelName,
                    manufacturerName: manufacturerName,
                    modelRegistrn: modelRegistrn,
                    modelQuantity:modelQuantity,
                    profileImg: profileImg,
                    modelColor: modelColor,
                    modelYear: modelYear
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
        }else{
            alert("Please fill all details")
        }
    });
});