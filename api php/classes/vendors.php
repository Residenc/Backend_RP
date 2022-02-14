<?php 
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    require_once "../config/Connection.php";
    class Vendors{

        public static function getVendor($cred_id){
            $db = new Connection();
            $query = "SELECT * FROM vendors WHERE credential_id=$cred_id";
            $result_vendor = $db->query($query);
            $credentials_query = ("SELECT * FROM credentials WHERE credential_id=$cred_id");
            $result_cred = $db->query($credentials_query);
            $data = [];
            if ($result_vendor->num_rows && $result_cred->num_rows) {
                while ( ($row_vendor = $result_vendor->fetch_assoc()) && ($row_cred = $result_cred->fetch_assoc()) ) {
                    $data[]=[
                        'names' => $row_vendor['names'],
                        'paternal' => $row_vendor['paternal'],
                        'maternal' => $row_vendor['maternal'],
                        'email' => $row_cred['email'],
                        'passwd' => $row_cred['passwd'],
                        'gender' => $row_vendor['gender'],
                        'phone' => $row_vendor['phone'],
                        'registration_date' => $row_vendor['registration_date'],
                    ];
                }
                return $data;
            }
            return $data;
        }


        public static function getVendorDefaultAddress($vendor_id){
            $db = new Connection();
            $query = "SELECT * FROM addresses_vendors WHERE vendor_id=$vendor_id AND default_address = 'TRUE'";
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


        public static function getVendorAddresses($vendor_id){
            $db = new Connection();
            $query = "SELECT * FROM addresses_vendors WHERE vendor_id=$vendor_id ORDER BY default_address DESC";
            $result_vendor = $db->query($query);
            $data = [];
            if ($result_vendor->num_rows) {
                while ( ($row = $result_vendor->fetch_assoc()) ) {
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


        public static function getVendorAddress($address_id){
            $db = new Connection();
            $query = "SELECT * FROM addresses_vendors WHERE address_id=$address_id";
            $result_vendor = $db->query($query);
            $data = [];
            if ($result_vendor->num_rows) {
                while ( ($row = $result_vendor->fetch_assoc()) ) {
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


        public static function insertVendorAddress($vendor_id, $address){
            $db = new Connection();
            $query = "INSERT INTO `addresses_vendors`(`vendor_id`, `address`) VALUES ('".$vendor_id."', '".$address."')";
            $db->query($query);
            if ($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }


        public static function updateAddressVendor($vendor_id, $address_id, $address, $default_address){
            $db = new Connection();
            $query = "UPDATE addresses_vendors SET  address = '".$address."', default_address = '".$default_address."' WHERE address_id=$address_id AND vendor_id=$vendor_id";
            $db->query($query);
            if($db->affected_rows) {
                if($default_address === 'TRUE'){
                    $query2 = "UPDATE addresses_vendors SET default_address = 'FALSE' WHERE vendor_id=$vendor_id AND default_address='TRUE' AND address_id NOT LIKE $address_id";
                    $db->query($query2);
                }
                return true;
            }
            return false;
        }


        public static function insertVendor($names, $paternal, $maternal, $email, $passwd){
            $db = new Connection();
            $queryInsert = "INSERT INTO vendors (credential_id, names, paternal, maternal, phone, gender, registration_date)
            VALUES(NULL, '".$names."', '".$paternal."', '".$maternal."', NULL, NULL, CURDATE())";
            $db->query($queryInsert);
            if ($db->affected_rows) {
                $result = mysqli_query($db, "SELECT MAX(vendor_id) FROM vendors WHERE names='".$names."' AND paternal='".$paternal."' AND maternal='".$maternal."'");
                $row = mysqli_fetch_array($result);
                $id_vendor = $row[0];
                $queryCredentials = "UPDATE credentials SET email='".$email."', passwd='".$passwd."' WHERE vendor_id='".$id_vendor."'";
                $db->query($queryCredentials);

                $result2 = mysqli_query($db, "SELECT MAX(credential_id) FROM credentials WHERE email='".$email."' AND passwd='".$passwd."'");
                $row2 = mysqli_fetch_array($result2);
                $id_credential = $row2[0];
                $querySetCredentials = "UPDATE vendors SET credential_id='".$id_credential."' WHERE vendor_id='".$id_vendor."'";
                $db->query($querySetCredentials);

                $result3 = mysqli_query($db, "SELECT MAX(business_id) FROM business WHERE vendor_id='".$id_vendor."'");
                $row3 = mysqli_fetch_array($result3);
                $id_business = $row3[0];
                $querySetBusiness =  "UPDATE vendors SET business_id='".$id_business."' WHERE vendor_id='".$id_vendor."'";
                $db->query($querySetBusiness);

                return TRUE;
            }
            return FALSE;
        }


        public static function updateInfoVendor($vendor_id, $names, $paternal, $maternal, $phone, $gender) {
            $db = new Connection();
            $query = "UPDATE vendors SET names='".$names."', paternal='".$paternal."', maternal='".$maternal."', phone='".$phone."', gender='".$gender."' WHERE vendor_id='".$vendor_id."'";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }


        public static function getAllBusiness(){
            $db = new Connection();
            $query = "SELECT * FROM business"; 
            $result = $db->query($query); 
            $data = [];
            if ($result->num_rows) { 
                while ($row = $result->fetch_assoc()) {
                    $data[]=[
                        'business_id' => $row['business_id'],
                        'name' => $row['name'],
                        'address' => $row['address'],
                        'about' => $row['about'],
                        'phone' => $row['phone'],
                        'email' => $row['email'],
                        'image' => $row['image']
                    ];
                }
                return $data;
            }
            return $data;
        }


        public static function getBusiness($vendor_id){
            $db = new Connection();
            $query = "SELECT * FROM business WHERE vendor_id=$vendor_id";
            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) {
                while ($row = $result->fetch_assoc()) {
                    $data[]=[
                        'business_id' => $row['business_id'],
                        'name' => $row['name'],
                        'address' => $row['address'],
                        'about' => $row['about'],
                        'phone' => $row['phone'],
                        'email' => $row['email'],
                        'image' => $row['image']
                    ];
                }
                return $data;
            }
            return $data;
        }


        public static function updateInfoBusiness($vendor_id, $name, $address, $about, $phone, $email, $image) {
            $db = new Connection();
            $query = "UPDATE business SET name='".$name."', address='".$address."', about='".$about."', phone='".$phone."', email='".$email."', image='".$image."' WHERE vendor_id='".$vendor_id."'";
            $db->query($query);
            if($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function updateCredentials($credential_id, $passwdOld, $passwdNew) {

            $helper = new Connection();
            $queryPass = "SELECT * FROM credentials WHERE passwd='".$passwdOld."' AND credential_id=$credential_id";
            $result = $helper->query($queryPass);
            if ($result->num_rows)
            {
                $db = new Connection();
                $query = "UPDATE credentials SET passwd='".$passwdNew."' WHERE credential_id=$credential_id";
                $db->query($query);
                return TRUE;
            }
            return FALSE;
        }

    }