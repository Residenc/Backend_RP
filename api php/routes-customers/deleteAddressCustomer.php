<?php
    header('Access-Control-Allow-Origin: http://localhost:4200');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin,  Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: DELETE");

    require_once "../classes/customers.php";

    if (isset($_GET['id'])) {
        if ($result = Customers::deleteAddressCustomer($_GET['id'])) {
            echo json_encode(['delete' => TRUE]);
        }
        else{
            echo json_encode(['delete' => FALSE]);
        }
    }
    else{
        echo json_encode(['delete' => FALSE]);
    }