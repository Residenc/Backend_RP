<?php

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');


    require_once "../config/Connection.php";


    class CartVendor{

        public static function insertCartItemVendor($vendor_id, $product_id, $quantity){

            $db = new Connection();
            $query = "INSERT INTO `cartitemsvendors`(`vendor_id`, `product_id`, `quantity`) VALUES ('".$vendor_id."', '".$product_id."', '".$quantity."')";
            $db->query($query);
            if ($db->affected_rows) {
                return TRUE;
            }
            return FALSE;

        }

        public static function getCartItemsVendor($vendor_id){
            $db = new Connection();
            $query = "SELECT cartitemsvendors.vendor_id, cartitemsvendors.quantity,cartitemsvendors.product_id,products.product_name, products.price FROM `cartitemsvendors` inner join products on cartitemsvendors.product_id = products.product_id where cartitemsvendors.vendor_id = $vendor_id";
            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) {
                while ( ($row = $result->fetch_assoc()) ) {
                    $data[]=[
                        'product_id' => $row['product_id'],
                        'vendor_id' => $row['vendor_id'],
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