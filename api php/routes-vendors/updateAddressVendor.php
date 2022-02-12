<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    require_once "../classes/vendors.php";

    $data = json_decode(file_get_contents('php://input')); //! trae un json con informacion que es capturada desde el html
    if($data != NULL){
        if($res = Vendors::updateAddressVendor($data->vendor_id, $data->address_id, $data->address, $data->default_address)){
            echo json_encode(['updateaddress' => TRUE]);
        }
        else{
            echo json_encode(['updateaddress' => FALSE]);
        }
    }
    else{
        echo json_encode(['updateaddress' => FALSE]);
    }