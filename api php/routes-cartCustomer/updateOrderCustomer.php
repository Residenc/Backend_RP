<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    require_once "../classes/cartCustomer.php";

    $data = json_decode(file_get_contents('php://input'));
    if($data != NULL){
        if($res = CartCustomer::updateOrderCustomer($data->cust_id, $data->order_id, $data->status, $data->payorder, $data->total)){
            echo json_encode(['update' => TRUE]);
        }
        else{
            echo json_encode(['update' => FALSE]);
        }
    }
    else{
        echo json_encode(['update' => FALSE]);
    }