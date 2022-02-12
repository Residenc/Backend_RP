<?php


    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');


    require_once "../config/Connection.php";


    class Customers{


        public static function getCustomer($cred_id){
            $db = new Connection();
            $customer_query = "SELECT * FROM customers WHERE credential_id=$cred_id";
            $result_cust = $db->query($customer_query);
            $credentials_query = ("SELECT * FROM credentials WHERE credential_id=$cred_id");
            $result_cred = $db->query($credentials_query);
            $data = [];
            if ($result_cust->num_rows && $result_cred->num_rows) {
                while ( ($row_cust = $result_cust->fetch_assoc()) && ($row_cred = $result_cred->fetch_assoc()) ) {
                    $data[]=[
                        'names' => $row_cust['names'],
                        'paternal' => $row_cust['paternal'],
                        'maternal' => $row_cust['maternal'],
                        'email' => $row_cred['email'],
                        'passwd' => $row_cred['passwd'],
                        'gender' => $row_cust['gender'],
                        'phone' => $row_cust['phone'],
                        'registration_date' => $row_cust['registration_date'],
                    ];
                }
                return $data;
            }
            return $data;
        }


        public static function getCustomerDefaultAddress($cust_id){
            $db = new Connection();
            $query = "SELECT * FROM addresses_customers WHERE cust_id=$cust_id AND default_address = 'TRUE'";
            $result_cust = $db->query($query);
            $data = [];
            if ($result_cust->num_rows) {
                while ( ($row = $result_cust->fetch_assoc()) ) {
                    $data[]=[
                        'address' => $row['address'],
                    ];
                }
                return $data;
            }
            return $data;
        }


        public static function getCustomerAddresses($cust_id){
            $db = new Connection();
            $query = "SELECT * FROM addresses_customers WHERE cust_id=$cust_id ORDER BY default_address DESC";
            $result_cust = $db->query($query);
            $data = [];
            if ($result_cust->num_rows) {
                while ( ($row = $result_cust->fetch_assoc()) ) {
                    $data[]=[
                        'address_id' => $row['address_id'],
                        'address' => $row['address'],
                        'default_address' => $row['default_address']
                    ];
                }
                return $data;
            }
            return $data;
        }


        public static function getCustomerAddress($address_id){
            $db = new Connection();
            $query = "SELECT * FROM addresses_customers WHERE address_id=$address_id";
            $result_cust = $db->query($query);
            $data = [];
            if ($result_cust->num_rows) {
                while ( ($row = $result_cust->fetch_assoc()) ) {
                    $data[]=[
                        'address_id' => $row['address_id'],
                        'address' => $row['address'],
                        'default_address' => $row['default_address']
                    ];
                }
                return $data;
            }
            return $data;
        }


        public static function insertCustomerAddress($cust_id, $address){
            $db = new Connection();
            $query = "INSERT INTO `addresses_customers`(`cust_id`, `address`) VALUES ('".$cust_id."', '".$address."')";
            $db->query($query);
            if ($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }


        public static function updateAddressCustomer($cust_id, $address_id, $address, $default_address){
            $db = new Connection();
            $query = "UPDATE addresses_customers SET  address = '".$address."', default_address = '".$default_address."' WHERE address_id=$address_id AND cust_id=$cust_id";
            $db->query($query);
            if($db->affected_rows) {
                if($default_address === 'TRUE'){
                    $query2 = "UPDATE addresses_customers SET default_address = 'FALSE' WHERE cust_id=$cust_id AND default_address='TRUE' AND address_id NOT LIKE $address_id";
                    $db->query($query2);
                }
                return true;
            }
            return false;
        }


        public static function insertCustomer($names, $paternal, $maternal, $email, $passwd){
            $db = new Connection();
            $queryInsert = "INSERT INTO customers (names, paternal, maternal, phone, gender, registration_date)
            VALUES('".$names."', '".$paternal."', '".$maternal."', NULL, NULL, CURDATE())";
            $db->query($queryInsert);
            if ($db->affected_rows) {
                $result = mysqli_query($db, "SELECT MAX(cust_id) FROM customers WHERE names='".$names."' AND paternal='".$paternal."' AND maternal='".$maternal."'");
                $row = mysqli_fetch_array($result);
                $id_cust = $row[0];
                $queryCredentials = "UPDATE credentials SET email='".$email."', passwd='".$passwd."' WHERE cust_id='".$id_cust."'";
                $db->query($queryCredentials);

                $result2 = mysqli_query($db, "SELECT MAX(credential_id) FROM credentials WHERE email='".$email."' AND passwd='".$passwd."'");
                $row2 = mysqli_fetch_array($result2);
                $id_credential = $row2[0];
                $querySetCredentials = "UPDATE customers SET credential_id='".$id_credential."' WHERE cust_id='".$id_cust."'";
                $db->query($querySetCredentials);
                return TRUE;
            }
            return FALSE;
        }


        public static function updateInfoCustomer($cust_id, $names, $paternal, $maternal, $phone, $gender) {
            $db = new Connection();
            $query = "UPDATE customers SET names='".$names."', paternal='".$paternal."', maternal='".$maternal."', phone='".$phone."', gender='".$gender."' WHERE cust_id='".$cust_id."'";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }
        

    }