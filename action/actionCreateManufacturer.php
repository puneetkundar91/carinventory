<?php
include '../library/model_base.php';

if ($_POST) {
    $response = array();
    if ((array_key_exists('manufacturerName', $_POST))) {
        $name = $_POST["manufacturerName"];
        
        if ($name != "") {
            $data = Model_Base::query("SELECT id FROM `manufacturer` WHERE manufacturer_name='{$name}'");
            if(empty($data)){
                $string = str_replace(" ", "-", $name);
                $string = preg_replace("/[^A-Za-z0-9\-]/", "", $string);
                $uniquename = strtolower(preg_replace("/-+/", "-", $string));
                $columnvalue = array(
                    "manufacturer_name"=>$name,
                    "date_added"=>date("Y-m-d"),
                    "uniquename"=>$uniquename
                );
                Model_Base::insert_row("manufacturer", $columnvalue);
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
