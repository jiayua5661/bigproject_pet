<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$host = 'localhost';
$dbname = 'petdb';
$user = 'root';
$password = '';

$uid = $_REQUEST['uid'];

try {

    $db = new PDO("mysql:host=${host};dbname=${dbname};charset=utf8mb4", $user);
    $sql = "select pid, pet_name, pet_headphoto, pet_species, pet_weight, pet_fur from pet_info where uid = ${uid}";
    $stmt =$db->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    # fetchAll(PDO::FETCH_ASSOC) fetchAll 是拿全部的陣列  PDO::FETCH_ASSOC 是只顯示KEY是欄位名稱跟value
    #預設顯示兩個 1.KEY是欄位名稱跟value   2.KEY是索引值跟value 

    //  資料庫塞圖片 這樣傳
    // 陣列圖片處理
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