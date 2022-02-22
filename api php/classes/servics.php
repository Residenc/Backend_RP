<?php 
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    require_once "../config/Connection.php";
    class Servics{

        
        public static function insertServics($vendor_id, $service_name, $description, $minprice, $maxprice, $category, $image){
            $db = new Connection();

            $result = mysqli_query($db, "SELECT business_id FROM business WHERE vendor_id=$vendor_id");
            $row = mysqli_fetch_array($result);
            $id_business = $row[0];


            $query = "INSERT INTO services (vendor_id, business_id, service_name, description, minprice, maxprice, category, image, registration_date)
            VALUES('".$vendor_id."', '".$id_business."', '".$service_name."', '".$description."', '".$minprice."', '".$maxprice."', '".$category."', '".$image."', CURDATE())";
            $db->query($query);
            if ($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }


        public static function getAllServics(){
            $db = new Connection();
            $query = "SELECT * FROM services";
            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) { 
                while ($row = $result->fetch_assoc()) {
                    $data[]=[
                        'service_id' => $row['service_id'],
                        'business_id' => $row['business_id'],
                        'service_name' => $row['service_name'],
                        'description' => $row['description'],
                        'minprice' => $row['minprice'],
                        'maxprice' => $row['maxprice'],
                        'category' => $row['category'],
                        'image' => $row['image'],
                        'registration_date' => $row['registration_date'],
                    ];
                }
                return $data;
            }
            return $data;
        }


        public static function getAllServicsOfVendor($vendor_id){
            $db = new Connection();
            $query = "SELECT * FROM services WHERE vendor_id='".$vendor_id."'";
            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) { 
                while ($row = $result->fetch_assoc()) {
                    $data[]=[
                        'service_id' => $row['service_id'],
                        'business_id' => $row['business_id'],
                        'service_name' => $row['service_name'],
                        'description' => $row['description'],
                        'minprice' => $row['minprice'],
                        'maxprice' => $row['maxprice'],
                        'category' => $row['category'],
                        'image' => $row['image'],
                        'registration_date' => $row['registration_date'],
                    ];
                }
                return $data;
            }
            return $data;
        }


        public static function getServics($service_id){
            $db = new Connection();
            $query = "SELECT * FROM services WHERE service_id='".$service_id."'";
            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) { 
                while ($row = $result->fetch_assoc()) {
                    $data[]=[
                        'service_id' => $row['service_id'],
                        'business_id' => $row['business_id'],
                        'service_name' => $row['service_name'],
                        'description' => $row['description'],
                        'minprice' => $row['minprice'],
                        'maxprice' => $row['maxprice'],
                        'category' => $row['category'],
                        'image' => $row['image'],
                        'registration_date' => $row['registration_date'],
                    ];
                }
                return $data;
            }
            return $data;
        }


        public static function updateServics($service_id, $service_name, $description, $minprice, $maxprice, $category, $image) {
            $db = new Connection();
            $query = "UPDATE services SET service_name='".$service_name."', description='".$description."', minprice='".$minprice."', maxprice='".$maxprice."', category='".$category."', image='".$image."' WHERE service_id=$service_id";
            $db->query($query);
            if ($db->affected_rows)
            {

                return TRUE;
            }
            return FALSE;
        }


        public static function delete($service_id){
            $db = new Connection();
            $query = "DELETE FROM services WHERE service_id=$service_id";
            $db->query($query);
            if ($db->affected_rows >= 0) {
                return TRUE;
            }
            return FALSE;
        }


    }