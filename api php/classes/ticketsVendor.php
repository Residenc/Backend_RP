<?php

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');


    require_once "../config/Connection.php";


    class TicketsVendor{


        public static function createTicketVendor($vendor_id, $service_id, $seller_id, $name, $phone, $email,  $comment){
            $db = new Connection();

            $query = "INSERT INTO `ticketsvendors`(`vendor_id`, `service_id`, `seller_id`, `name`, `phone`, `email`, `comment`, `registration_date`)
            VALUES('".$vendor_id."', '".$service_id."', '".$seller_id."', '".$name."', '".$phone."', '".$email."', '".$comment."', CURDATE())";
            $db->query($query);
            if ($db->affected_rows) {
                return TRUE;
            }
            return FALSE;
        }

        public static function getTicketsVendor($vendor_id){
            $db = new Connection();

            $query = "SELECT ticketsvendors.ticket_id, ticketsvendors.service_id, ticketsvendors.seller_id, ticketsvendors.name, ticketsvendors.phone, ticketsvendors.email, ticketsvendors.comment, ticketsvendors.registration_date, services.service_name, services.category
                      FROM ticketsvendors INNER JOIN services ON ticketsvendors.service_id = services.service_id  WHERE ticketsvendors.vendor_id = $vendor_id";

            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) {
                while ( ($row = $result->fetch_assoc()) ) {
                    $data[]=[
                        'ticket_id' => $row['ticket_id'],                   
                        'service_id' => $row['service_id'],                   
                        'seller_id' => $row['seller_id'],
                        'service_name' => $row['service_name'],                            
                        'category' => $row['category'],                            
                        'name' => $row['name'],                   
                        'phone' => $row['phone'],                   
                        'email' => $row['email'],                   
                        'comment' => $row['comment'],                   
                        'registration_date' => $row['registration_date']                
                    ];
                }
                return $data;
            }
            return $data;
        }

        public static function getTicketInfo($ticket_id){
            $db = new Connection();

            $query = "SELECT ticketsvendors.ticket_id, ticketsvendors.service_id, ticketsvendors.seller_id, ticketsvendors.name, ticketsvendors.phone, ticketsvendors.email, ticketsvendors.comment, ticketsvendors.registration_date, services.service_name, services.category
            FROM ticketsvendors INNER JOIN services ON ticketsvendors.service_id = services.service_id  WHERE ticketsvendors.ticket_id = $ticket_id";


            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) {
                while ( ($row = $result->fetch_assoc()) ) {
                    $data[]=[
                        'ticket_id' => $row['ticket_id'],                   
                        'service_id' => $row['service_id'],                   
                        'seller_id' => $row['seller_id'],
                        'service_name' => $row['service_name'],                            
                        'category' => $row['category'],                            
                        'name' => $row['name'],                   
                        'phone' => $row['phone'],                   
                        'email' => $row['email'],                   
                        'comment' => $row['comment'],                   
                        'registration_date' => $row['registration_date']                         
                    ];
                }
                return $data;
            }
            return $data;
        }

        public static function getTicketsCustomerRequest($seller_id){
            $db = new Connection();

            $query = "SELECT ticketscustomers.ticket_id, ticketscustomers.service_id, ticketscustomers.seller_id, ticketscustomers.name, ticketscustomers.phone, ticketscustomers.email, ticketscustomers.comment, ticketscustomers.registration_date, services.service_name, services.category
            FROM ticketscustomers INNER JOIN services ON ticketscustomers.service_id = services.service_id  WHERE ticketscustomers.seller_id = $seller_id";

            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) {
                while ( ($row = $result->fetch_assoc()) ) {
                    $data[]=[
                        'ticket_id' => $row['ticket_id'],                   
                        'service_id' => $row['service_id'],                   
                        'seller_id' => $row['seller_id'],
                        'service_name' => $row['service_name'],                            
                        'category' => $row['category'],                            
                        'name' => $row['name'],                   
                        'phone' => $row['phone'],                   
                        'email' => $row['email'],                   
                        'comment' => $row['comment'],                   
                        'registration_date' => $row['registration_date']                  
                    ];
                }
                return $data;
            }
            return $data;
        }

        public static function getTicketsVendorRequest($seller_id){
            $db = new Connection();

            $query = "SELECT ticketsvendors.ticket_id, ticketsvendors.service_id, ticketsvendors.seller_id, ticketsvendors.name, ticketsvendors.phone, ticketsvendors.email, ticketsvendors.comment, ticketsvendors.registration_date, services.service_name, services.category
                      FROM ticketsvendors INNER JOIN services ON ticketsvendors.service_id = services.service_id  WHERE ticketsvendors.seller_id = $seller_id";

            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) {
                while ( ($row = $result->fetch_assoc()) ) {
                    $data[]=[
                        'ticket_id' => $row['ticket_id'],                   
                        'service_id' => $row['service_id'],                   
                        'seller_id' => $row['seller_id'],
                        'service_name' => $row['service_name'],                            
                        'category' => $row['category'],                            
                        'name' => $row['name'],                   
                        'phone' => $row['phone'],                   
                        'email' => $row['email'],                   
                        'comment' => $row['comment'],                   
                        'registration_date' => $row['registration_date']                        
                    ];
                }
                return $data;
            }
            return $data;
        }

        public static function getTicketVendorInfo($ticket_id){
            $db = new Connection();

            $query = "SELECT ticketsvendors.ticket_id, ticketsvendors.service_id, ticketsvendors.seller_id, ticketsvendors.name, ticketsvendors.phone, ticketsvendors.email, ticketsvendors.comment, ticketsvendors.registration_date, services.service_name, services.category
            FROM ticketsvendors INNER JOIN services ON ticketsvendors.service_id = services.service_id  WHERE ticketsvendors.ticket_id = $ticket_id";


            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) {
                while ( ($row = $result->fetch_assoc()) ) {
                    $data[]=[
                        'ticket_id' => $row['ticket_id'],                   
                        'service_id' => $row['service_id'],                   
                        'seller_id' => $row['seller_id'],
                        'service_name' => $row['service_name'],                            
                        'category' => $row['category'],                            
                        'name' => $row['name'],                   
                        'phone' => $row['phone'],                   
                        'email' => $row['email'],                   
                        'comment' => $row['comment'],                   
                        'registration_date' => $row['registration_date']                      
                    ];
                }
                return $data;
            }
            return $data;
        }

        public static function getTicketCustomerInfo($ticket_id){
            $db = new Connection();

            $query = "SELECT ticketscustomers.ticket_id, ticketscustomers.service_id, ticketscustomers.seller_id, ticketscustomers.name, ticketscustomers.phone, ticketscustomers.email, ticketscustomers.comment, ticketscustomers.registration_date, services.service_name, services.category
            FROM ticketscustomers INNER JOIN services ON ticketscustomers.service_id = services.service_id  WHERE ticketscustomers.ticket_id = $ticket_id";
            

            $result = $db->query($query);
            $data = [];
            if ($result->num_rows) {
                while ( ($row = $result->fetch_assoc()) ) {
                    $data[]=[
                        'ticket_id' => $row['ticket_id'],                   
                        'service_id' => $row['service_id'],                   
                        'seller_id' => $row['seller_id'],
                        'service_name' => $row['service_name'],                            
                        'category' => $row['category'],                            
                        'name' => $row['name'],                   
                        'phone' => $row['phone'],                   
                        'email' => $row['email'],                   
                        'comment' => $row['comment'],                   
                        'registration_date' => $row['registration_date']                      
                    ];
                }
                return $data;
            }
            return $data;
        }


    }
