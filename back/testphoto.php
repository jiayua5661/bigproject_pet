<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$host = 'localhost';
$dbname = 'petdb';
$user = 'root';
$password = '';

try {

    $db = new PDO("mysql:host=${host};dbname=${dbname};charset=utf8mb4", $user);
    $sql = "select pet_headphoto from pet_info";
    $stmt =$db->prepare($sql);
    // $stmt =$db->query($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    # fetchAll(PDO::FETCH_ASSOC) fetchAll 是拿全部的陣列  PDO::FETCH_ASSOC 是只顯示KEY是欄位名稱跟value
    #預設顯示兩個 1.KEY是欄位名稱跟value   2.KEY是索引值跟value 
    
    $result = array_map(function($row){
        // 找副檔名
        $mime_type = (new finfo(FILEINFO_MIME_TYPE))->buffer($row['pet_headphoto']);
        // 圖片檔轉字串
        $base64 = base64_encode($row['pet_headphoto']);
        $row['pet_headphoto'] = "data:${mime_type};base64,${base64}";
        return $row;
    }, $rows);

    echo json_encode($result);
    
} catch (PDOExcaption $e){
    print($e);
}