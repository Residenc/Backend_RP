<?php 
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    require_once "../config/Connection.php";
    class Products{

        
        public static function insertProduct($vendor_id, $product_name, $description, $price, $brand, $quantity, $category){
            $db = new Connection();

            $result = mysqli_query($db, "SELECT business_id FROM business WHERE vendor_id=$vendor_id");
            $row = mysqli_fetch_array($result);
            $id_business = $row[0];


            $query = "INSERT INTO products (vendor_id, business_id, product_name, description, price, brand, quantity, category, registration_date)
            VALUES('".$vendor_id."', '".$id_business."', '".$product_name."', '".$description."', '".$price."', '".$brand."', '".$quantity."', '".$category."', CURDATE())";
            $db->query($query);
            if ($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }


        public static function getAllProducts(){
            $db = new Connection();

            //$query = " SELECT products.product_id, products.vendor_id, products.brand, products.category, products.description, products.price, products.product_name,  products.quantity, products.registration_date, products.business_id,  business.name
                       //FROM products INNER JOIN business on products.business_id = business.business_id";
            $query = "SELECT products.product_id, products.vendor_id, products.brand, products.category, products.description, filesproducts.path, products.price, products.product_name,  products.quantity, products.registration_date, products.business_id, business.name FROM products INNER JOIN business on products.business_id = business.business_id 
                      INNER JOIN filesproducts on filesproducts.product_id = products.product_id GROUP BY products.product_id;";
            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) { 
                while ($row = $result->fetch_assoc()) {
                    $data[]=[
                        'product_id' => $row['product_id'],
                        'vendor_id' => $row['vendor_id'],
                        'business_id' => $row['business_id'],
                        'business_name' => $row['name'],
                        'product_name' => $row['product_name'],
                        'description' => $row['description'],
                        'price' => $row['price'],
                        'brand' => $row['brand'],
                        'quantity' => $row['quantity'],
                        'category' => $row['category'],
                        'path' => $row['path'],
                        'registration_date' => $row['registration_date'],
                    ];
                }
                return $data;
            }
            return $data;
        }


        public static function getAllProductsOfVendor($vendor_id){
            $db = new Connection();
            //$query = " SELECT products.product_id, products.vendor_id, products.brand, products.category, products.description, products.image,  products.price, products.product_name,  products.quantity, products.registration_date, products.business_id,  business.name
                       //FROM products INNER JOIN business on products.business_id = business.business_id WHERE products.vendor_id='".$vendor_id."'";
            $query = "SELECT products.product_id, products.vendor_id, products.brand, products.category, products.description, filesproducts.path, products.price, products.product_name,  products.quantity, products.registration_date, products.business_id, business.name FROM products INNER JOIN business on products.business_id = business.business_id 
            INNER JOIN filesproducts on filesproducts.product_id = products.product_id WHERE products.vendor_id='".$vendor_id."' GROUP BY products.product_id;";
            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) { 
                while ($row = $result->fetch_assoc()) {
                    $data[]=[
                        'product_id' => $row['product_id'],
                        'vendor_id' => $row['vendor_id'],
                        'business_id' => $row['business_id'],
                        'business_name' => $row['name'],
                        'product_name' => $row['product_name'],
                        'description' => $row['description'],
                        'price' => $row['price'],
                        'brand' => $row['brand'],
                        'quantity' => $row['quantity'],
                        'category' => $row['category'],
                        'path' => $row['path'],
                        'registration_date' => $row['registration_date'],
                    ];
                }
                return $data;
            }
            return $data;
        }


        public static function getProduct($product_id){
            $db = new Connection();
            //$query = "SELECT products.product_id, products.vendor_id, products.brand, products.category, products.description, products.image,  products.price, products.product_name,  products.quantity, products.registration_date, products.business_id,  business.name
                      //FROM products INNER JOIN business on products.business_id = business.business_id WHERE products.product_id='".$product_id."'";
            $query = "SELECT products.product_id, products.vendor_id, products.brand, products.category, products.description, filesproducts.path, products.price, products.product_name,  products.quantity, products.registration_date, products.business_id, business.name FROM products INNER JOIN business on products.business_id = business.business_id 
            INNER JOIN filesproducts on filesproducts.product_id = products.product_id WHERE products.product_id='".$product_id."' GROUP BY products.product_id;";
            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) { 
                while ($row = $result->fetch_assoc()) {
                    $data[]=[
                        'product_id' => $row['product_id'],
                        'vendor_id' => $row['vendor_id'],
                        'business_id' => $row['business_id'],
                        'business_name' => $row['name'],
                        'product_name' => $row['product_name'],
                        'description' => $row['description'],
                        'price' => $row['price'],
                        'brand' => $row['brand'],
                        'quantity' => $row['quantity'],
                        'category' => $row['category'],
                        'path' => $row['path'],
                        'registration_date' => $row['registration_date'],
                    ];
                }
                return $data;
            }
            return $data;
        }


        public static function updateProduct($product_id, $product_name, $description, $price, $brand, $quantity, $category) {
            $db = new Connection();
            $query = "UPDATE products SET product_name='".$product_name."', description='".$description."', price='".$price."', brand='".$brand."', quantity='".$quantity."', category='".$category."', WHERE product_id=$product_id";
            $db->query($query);
            if ($db->affected_rows)
            {

                return TRUE;
            }
            return FALSE;
        }


        public static function delete($product_id){
            $db = new Connection();
            $query = "DELETE FROM products WHERE product_id=$product_id";
            $db->query($query);
            if ($db->affected_rows >= 0) {
                return TRUE;
            }
            return FALSE;
        }


    }