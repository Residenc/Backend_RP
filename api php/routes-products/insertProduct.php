<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    require_once "../classes/products.php";

    $data = json_decode(file_get_contents('php://input'));
        if($data != NULL){
            if(Products::insertProduct($data->vendor_id, $data->product_name, $data->description, $data->price, $data->brand, $data->quantity, $data->category, $data->image)){
                echo json_encode(['insert' => TRUE]);
            }
            else{
                echo json_encode(['insert' => FALSE]);
            }
        }
        else{
            echo json_encode(['insert' => FALSE]);
        }