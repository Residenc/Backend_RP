<?php 
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    require_once "../config/Connection.php";
    include '../vendor/autoload.php';
    use \Firebase\JWT\JWT;

    $json = file_get_contents('php://input');
    $params = json_decode($json);
    $db = new Connection();
    $row = mysqli_query($db, "SELECT * FROM credentials WHERE email='$params->email' and passwd='$params->passwd'");
             
  
    if ($result = mysqli_fetch_array($row))
    {
        $secret_key = "tokenized";
        $payload = [
            'iss' => "localhost",
            'aud' => 'localhost',
            'exp' => time() + 3000, //30 min para expirar
            'data' => [
                'cred' => $result['credential_id'],
                'vend' => $result['vendor_id'],
                'cust' => $result['cust_id'],
                'role' => $result['role'],
            ],
        ];
    }
    
    $token = JWT::encode($payload, $secret_key, 'HS256');
    echo json_encode(['token' => $token]);

?>
