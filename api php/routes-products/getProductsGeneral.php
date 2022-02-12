<?php
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    require_once "../classes/products.php";

    if(isset($_GET['id'])){
        echo json_encode(Products::getProduct($_GET['id']));
    }
    else{
        echo json_encode(Products::getAllProducts());
    }