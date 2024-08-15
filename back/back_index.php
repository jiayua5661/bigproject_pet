<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$host = 'localhost';
$dbname = 'happypet_DB';
$user = 'root';
$password = '';

try {
    $account = $_REQUEST['account'];
    $pwd = $_REQUEST['password'];

    $db = new PDO("mysql:host=${host};dbname=${dbname};charset=utf8mb4", $user);
    $sql = 'select * from userinfo where account = ? and password = ?';
    $stmt =$db->prepare($sql);
    $stmt->execute([$account, $pwd]);
    $rows = $stmt->fetchAll();

    foreach($rows as $row){
        echo "{$row['permission']}";
    }
    
} catch (PDOExcaption $e){
    print($e);
}