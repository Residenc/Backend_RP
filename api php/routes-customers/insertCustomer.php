<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    require_once "../classes/customers.php";

    $data = json_decode(file_get_contents('php://input'));
        if($data != NULL){
            if(Customers::insertCustomer($data->names, $data->paternal, $data->maternal, $data->email, $data->passwd)){
                echo json_encode(['insert' => TRUE]);
            }
            else{
                echo json_encode(['insert' => FALSE]);
            }
        }
        else{
            echo json_encode(['insert' => FALSE]);
        }