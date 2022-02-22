<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    require_once "../classes/servics.php";

    if(isset($_GET['id'])){
        echo json_encode(Servics::getAllServicsOfVendor($_GET['id']));
    }
    else{
        echo json_encode(['servics' => FALSE]);
    }