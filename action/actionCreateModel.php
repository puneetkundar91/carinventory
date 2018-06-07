<?php
include '../library/model_base.php';

if ($_POST) {
    $response = array();
    if ((array_key_exists('modelName', $_POST))) {
        $name = $_POST["modelName"];
        $modelColor = $_POST["modelColor"];
        $profileImg = $_POST["profileImg"];
        $manufacturerName = $_POST["manufacturerName"];
        $modelRegistrn = $_POST["modelRegistrn"];
        $modelQuantity = $_POST["modelQuantity"];
        $modelYear = $_POST["modelYear"];
        
        if ($name != "") {
            $data = Model_Base::query("SELECT id FROM `models` WHERE model_name='{$name}'");
            if(empty($data)){
                $string = str_replace(" ", "-", $name);
                $string = preg_replace("/[^A-Za-z0-9\-]/", "", $string);
                $uniquename = strtolower(preg_replace("/-+/", "-", $string));
                $columnvalue = array(
                    "model_name"=>$name,
                    "model_color"=>$modelColor,
                    "profile_img"=>$profileImg,
                    "manufacturer"=>$manufacturerName,
                    "count"=>$modelQuantity,
                    "registrn_number"=>$modelRegistrn,
                    "model_year"=>$modelYear,
                    "date_added"=>date("Y-m-d"),
                    "uniquename"=>$uniquename
                );
                Model_Base::insert_row("models", $columnvalue);
                $response["status"] = "success";
                $response["msg"] = "Created successfully";
            }else {
                $response["status"] = "error";
                $response["msg"] = "Already exists";
            }
        } else {
            $response["status"] = "error";
            $response["msg"] = "Invalid data";
        }
    } else {
        $response["status"] = "error";
        $response["msg"] = "Invalid data";
    }
    
    echo json_encode($response);
    exit();
}
?>
