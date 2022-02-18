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

        public static function getCartItemsCustomer($cust_id){
            $db = new Connection();
            $query = "SELECT cartitemscustomers.cust_id, cartitemscustomers.quantity,cartitemscustomers.product_id,products.product_name, products.price FROM `cartitemscustomers` inner join products on cartitemscustomers.product_id = products.product_id where cartitemscustomers.cust_id = $cust_id";
            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) {
                while ( ($row = $result->fetch_assoc()) ) {
                    $data[]=[
                        'product_id' => $row['product_id'],
                        'cust_id' => $row['cust_id'],
                        'product_name' => $row['product_name'],
                        'price' => $row['price'],
                        'quantity' => $row['quantity'],
                        'total' => $row['price']*$row['quantity']
                    ];
                }
                return $data;
            }
            return $data;
        }


    }