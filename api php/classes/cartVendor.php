<?php

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');


    require_once "../config/Connection.php";


    class CartVendor{

        public static function insertCartItemVendor($vendor_id, $product_id, $quantity){
            $db = new Connection();
            $q=("SELECT * FROM cartitemsvendors WHERE product_id=$product_id AND vendor_id=$vendor_id");
            $result = $db->query($q);
            if ($result->num_rows){
                $updateQuantity = "UPDATE cartitemsvendors SET quantity=quantity+'".$quantity."' WHERE product_id=$product_id AND vendor_id=$vendor_id";
                $db->query($updateQuantity);
                if ($db->affected_rows)
                {
    
                    return TRUE;
                }
                return FALSE;
            }
            $query = "INSERT INTO `cartitemsvendors`(`vendor_id`, `product_id`, `quantity`) VALUES ('".$vendor_id."', '".$product_id."', '".$quantity."')";
            $db->query($query);
            if ($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function getCartItemsVendor($vendor_id){
            $db = new Connection();
            $query = "SELECT cartitemsvendors.cartitem_id,  cartitemsvendors.vendor_id, cartitemsvendors.quantity,cartitemsvendors.product_id,products.product_name, products.quantity AS stock, products.price FROM `cartitemsvendors` inner join products on cartitemsvendors.product_id = products.product_id where cartitemsvendors.vendor_id = $vendor_id";
            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) {
                while ( ($row = $result->fetch_assoc()) ) {
                    $data[]=[
                        'cartitem_id' => $row['cartitem_id'],
                        'product_id' => $row['product_id'],
                        'vendor_id' => $row['vendor_id'],
                        'product_name' => $row['product_name'],
                        'price' => $row['price'],
                        'stock' => $row['stock'],
                        'quantity' => $row['quantity'],
                        'total' => $row['price']*$row['quantity']
                    ];
                }
                return $data;
            }
            return $data;
        }

        public static function deleteCartItemVendor($cartitem_id){
            $db = new Connection();
            $query = "DELETE FROM `cartitemsvendors` WHERE `cartitemsvendors`.`cartitem_id`= $cartitem_id ";
            $db->query($query);
            if ($db->affected_rows >= 0) {
                return TRUE;
            }
            return FALSE;
        }

        public static function updateCartItemVendor($cartitem_id, $vendor_id, $quantity){
            $db = new Connection();
            $query = "UPDATE `cartitemsvendors` SET quantity='".$quantity."'WHERE cartitem_id=$cartitem_id AND vendor_id=$vendor_id";
            $db->query($query);
            if ($db->affected_rows)
            {

                return TRUE;
            }
            return FALSE;
        }


    }


    /*
    
            public static function insertCartItemVendor($vendor_id, $product_id, $quantity){
            
            $db = new Connection();
            $query = "INSERT INTO `cartitemsvendors`(`vendor_id`, `product_id`, `quantity`) VALUES ('".$vendor_id."', '".$product_id."', '".$quantity."')";
            $db->query($query);
            if ($db->affected_rows) {
                return TRUE;
            }
            return FALSE;

        }
    
    */