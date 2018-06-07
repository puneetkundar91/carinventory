<?php
session_start();
include '../library/model_base.php';

if ($_POST) {
    $response = array();
    if ((array_key_exists('username', $_POST)) && (array_key_exists('pwd', $_POST))) {
        $username = $_POST["username"];
        $pwd = $_POST["pwd"];
        
        if ($username != "" && $pwd != "") {
            $data = Model_Base::query("SELECT username FROM `users` WHERE username='{$username}' AND password='{$pwd}'");
            if(!empty($data)){
                $_SESSION["username"]=$data[0]->username;
                $response["status"] = "success";
                $response["msg"] = "Logged in successfully";
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
