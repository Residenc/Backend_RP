<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    require_once "../classes/customers.php";

    $data = json_decode(file_get_contents('php://input')); //! trae un json con informacion que es capturada desde el html
    if($data != NULL){
        if($res = Customers::updateInfoCustomer($data->cust_id, $data->names, $data->paternal, $data->maternal, $data->phone, $data->gender)){
            echo json_encode(['update' => TRUE]);
        }
        else{
            echo json_encode(['update' => FALSE]);
        }
    }
    else{
        echo json_encode(['update' => FALSE]);
    }