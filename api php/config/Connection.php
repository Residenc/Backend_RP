<?php 
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    class Connection extends mysqli{
        function __construct()
        {
            //parent:: __construct('162.241.62.187', 'storerpp_admin', '_ewC*0nu8={5', 'storerpp_db');
            parent:: __construct('localhost', 'root', '', 'db_storeRP');
            $this->connect_error == NULL ? 'Connection Succesful' : die('Connection Failed');
        }
    }