<?php 
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

    require_once "../config/Connection.php";

    $json = file_get_contents('php://input');
    $params = json_decode($json);
    $db = new Connection();
    $duplicate = mysqli_query($db, "SELECT * FROM credentials WHERE email='$params->email'");
    $dataduplicate = mysqli_num_rows($duplicate);
    $result = mysqli_fetch_array($duplicate);
    if ($dataduplicate != 0) 
    {   
        $data = [
            'email' => $result['email'],
        ];
    }
    $json = json_encode($data);
    echo $json; 
?>