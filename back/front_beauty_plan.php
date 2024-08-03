<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$host = 'localhost';
$dbname = 'petdb';
$user = 'root';
$password = '';

try {

    $db = new PDO("mysql:host=${host};dbname=${dbname};charset=utf8mb4", $user);
    $sql = 'select * from beauty_plan';
    $stmt =$db->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    # fetchAll(PDO::FETCH_ASSOC) fetchAll 是拿全部的陣列  PDO::FETCH_ASSOC 是只顯示KEY是欄位名稱跟value
    #預設顯示兩個 1.KEY是欄位名稱跟value   2.KEY是索引值跟value 

    echo json_encode($rows);
    
} catch (PDOExcaption $e){
    print($e);
}