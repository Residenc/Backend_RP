<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin,  Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: DELETE");

    require_once "../classes/cartVendor.php";

    if (isset($_GET['id'])) {
        if ($result = CartVendor::deleteCartItemVendor($_GET['id'])) {
            echo json_encode(['delete' => TRUE]);
        }
        else{
            echo json_encode(['delete' => FALSE]);
        }
    }
    else{
        echo json_encode(['delete' => FALSE]);
    }