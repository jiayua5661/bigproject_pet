<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../vendor/autoload.php';
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = "your_secret_key"; // 共享密鑰

header('Content-Type: application/json');

$headers = apache_request_headers();
if (isset($headers['Authorization'])) {
    $authHeader = $headers['Authorization'];
    list($jwt) = sscanf($authHeader, 'Bearer %s');

    if ($jwt) {
        try {
            // Decode the JWT
            $decoded = JWT::decode($jwt, new key ($key, 'HS256'));

            $host = 'localhost';
            $dbname = 'happypet_DB_bk';
            $user = 'root';
            $password = '';

            $uid = $_REQUEST['uid'];
            $usernamehs = $_REQUEST['usernamehs'];

            $db = new PDO("mysql:host=${host};dbname=${dbname};charset=utf8mb4", $user);
            $sql = "select account from back_userinfo where id = ?;";
            $stmt =$db->prepare($sql);
            $stmt->execute([$uid]);
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);


            if($usernamehs == '6ee4a469cd4e91053847f5d3fcb61dbcc91e8f0ef10be7748da4c4a1ba382d17'){
                echo json_encode(array("message" => "OK"));
            }else if($decoded->data->username == $rows['account'] && $usernamehs == hash('sha256', $rows['account'])) {
                echo json_encode(array("message" => "OK"));
            } else {
                echo json_encode(array("message" => "NO"));
            }
            
        } catch (Exception $e) {
            // echo json_encode(array("message" => "Unauthorized", "error" => $e->getMessage()));
            http_response_code(401);
            echo json_encode(array("message" => "Access denied.", "error" => $e->getMessage()));
            exit();
        }
    } else {
        echo json_encode(array("message" => "Unauthorized"));
    }
} else {
    echo json_encode(array("message" => "Unauthorized"));
}
?>
