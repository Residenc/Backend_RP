<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    require_once "../classes/products.php";

    $data = json_decode(file_get_contents('php://input')); //! trae un json con informacion que es capturada desde el html
    if($data != NULL){
        if($res = Products::updateProduct($data->product_id, $data->product_name, $data->description, $data->price, $data->brand, $data->quantity, $data->category)){
            echo json_encode(['update' => TRUE]);
        }
        else{
            echo json_encode(['update' => FALSE]);
        }
    }
    else{
        echo json_encode(['update' => FALSE]);
    }