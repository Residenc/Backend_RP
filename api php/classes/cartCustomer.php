<?php

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');


    require_once "../config/Connection.php";


    class CartCustomer{

        public static function insertCartItemCustomer($cust_id, $product_id, $quantity){

            $db = new Connection();
            $query = "INSERT INTO `cartitemscustomers`(`cust_id`, `product_id`, `quantity`) VALUES ('".$cust_id."', '".$product_id."', '".$quantity."')";
            $db->query($query);
            if ($db->affected_rows) {
                return TRUE;
            }
            return FALSE;

        }


    }