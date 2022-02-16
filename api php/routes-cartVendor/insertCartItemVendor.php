<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    require_once "../classes/cartVendor.php";

    $data = json_decode(file_get_contents('php://input'));
        if($data != NULL){
            if(CartVendor::insertCartItemVendor($data->vendor_id, $data->product_id, $data->quantity)){
                echo json_encode(['insertcartitem' => TRUE]);
            }
            else{
                echo json_encode(['insertcartitem' => FALSE]);
            }
        }
        else{
            echo json_encode(['insertcartitem' => FALSE]);
        }