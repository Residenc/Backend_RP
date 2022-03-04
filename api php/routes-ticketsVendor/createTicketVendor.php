<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    require_once "../classes/ticketsVendor.php";

    $data = json_decode(file_get_contents('php://input'));
        if($data != NULL){
            if(TicketsVendor::createTicketVendor($data->vendor_id, $data->service_id, $data->seller_id, $data->name, $data->phone, $data->email,  $data->comment)){
                echo json_encode(['insert' => TRUE]);
            }
            else{
                echo json_encode(['insert' => FALSE]);
            }
        }
        else{
            echo json_encode(['insert' => FALSE]);
        }