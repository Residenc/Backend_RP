<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    require_once "../classes/vendors.php";

    $data = json_decode(file_get_contents('php://input'));
        if($data != NULL){
            if(Vendors::insertVendorAddress($data->vendor_id, $data->address)){
                echo json_encode(['insertaddress' => TRUE]);
            }
            else{
                echo json_encode(['insertaddress' => FALSE]);
            }
        }
        else{
            echo json_encode(['insertaddress' => FALSE]);
        }