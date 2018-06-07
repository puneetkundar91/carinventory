<?php
include '../library/model_base.php';

if ($_POST) {
    $response = array();
    if ((array_key_exists('rowName', $_POST))) {
        $rowName = $_POST["rowName"];
        
        if ($rowName != "") {
            $data = Model_Base::query("SELECT id FROM `models` WHERE uniquename='{$rowName}'");
            if(!empty($data)){
                $arraycolumn = array(array("colm" => "uniquename", "condtn" => "=", "val" => $rowName, "optr" => ""));
                Model_Base::delete_rows("models", $arraycolumn);
                $response["status"] = "success";
                $response["msg"] = "Deleted successfully";
            }else {
                $response["status"] = "error";
                $response["msg"] = "Invalid data";
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
