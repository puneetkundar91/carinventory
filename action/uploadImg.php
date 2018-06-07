<?php

if (!empty($_FILES)) {
    $target_dir = "../upload/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $msg = "";
    $response = array();

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        $msg = "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $msg = "File is not an image.";
        $uploadOk = 0;
    }
    
    if ($_FILES["image"]["size"] > 900000) {
        $msg = "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        $response["status"] = "error";
        $response["msg"] = $msg;
        echo json_encode($response);
        exit();
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $response["status"] = "success";
            $msg = basename($_FILES["image"]["name"]);
            $response["msg"] = $msg;
            echo json_encode($response);
            exit();
        } else {
            $response["status"] = "error";
            $msg = "Sorry, there was an error uploading your file.";
            $response["msg"] = $msg;
            echo json_encode($response);
            exit();
        }
    }
}
?>

