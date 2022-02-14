<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    require_once "../classes/vendors.php";

    $data = json_decode(file_get_contents('php://input'));
    if($data != NULL){
        if($res = Vendors::updateCredentials($data->credential_id, $data->passwdOld, $data->passwdNew)){
            echo json_encode(['update' => TRUE]);
        }
        else{
            echo json_encode(['update' => FALSE]);
        }
    }
    else{
        echo json_encode(['update' => FALSE]);
    }