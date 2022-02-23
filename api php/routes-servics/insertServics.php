<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    require_once "../classes/servics.php";

    $data = json_decode(file_get_contents('php://input'));
        if($data != NULL){
            if(Servics::insertServics($data->vendor_id, $data->service_name, $data->description, $data->minprice, $data->maxprice, $data->category)){
                echo json_encode(['insert' => TRUE]);
            }
            else{
                echo json_encode(['insert' => FALSE]);
            }
        }
        else{
            echo json_encode(['insert' => FALSE]);
        }