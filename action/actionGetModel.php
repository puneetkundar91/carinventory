<?php
session_start();
include '../library/model_base.php';

if ($_POST) {
    $response = array();
    if ((array_key_exists('rowName', $_POST))) {
        $rowName = $_POST["rowName"];
        $str = "";
        if ($rowName != "") {
            $data = Model_Base::query("SELECT * FROM `models` WHERE uniquename='{$rowName}'");
            if(!empty($data)){
                $str .= "  <tr>
                            <th>Model name</th>
                            <td>".$data[0]->model_name."</td>
                          </tr>
                          <tr>
                            <th>Manufacturer</th>
                            <td>".$data[0]->manufacturer."</td>
                          </tr>
                          <tr>
                            <th>Registration number</th>
                            <td>".$data[0]->registrn_number."</td>
                          </tr>
                          <tr>
                            <th>Model year</th>
                            <td>".$data[0]->model_year."</td>
                          </tr>
                          <tr>
                            <th>Image</th>
                            <td><img src='".$data[0]->profile_img."' width='50' height='50'/></td>
                          </tr>
                          <tr>
                            <th>Model color</th>
                            <td>".$data[0]->model_color."</td>
                          </tr>";
                $response["status"] = "success";
                $response["msg"] = $str;
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
