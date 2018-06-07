$(document).ready(function () {
        $('#example').dataTable();
        $("#btnCreateManufacturer").click(function(e){
            e.preventDefault();
            var manufacturerName = $("#manufacturerName").val();
            if (manufacturerName != "") {
                $.ajax({
                    "url": urlpath + "action/actionCreateManufacturer.php",
                    "type": "POST",
                    "async": false,
                    "data": {
                        manufacturerName: manufacturerName
                    },
                    "success": function (data) {
                        var data = JSON.parse(data);
                        if (data.status == "success") {
                            alert(data.msg)
                            window.location.href = urlpath+"manufacturer.php";
                        } else {
                            alert(data.msg)
                        }
                    }
                });
            } else {
                alert("Please Enter Manufacturer name");
            }
        });
    });