<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$host = 'localhost';
$dbname = 'happypet_DB';
$user = 'root';
$password = null;

try {
    $db = new mysqli($host, $user, $password, $dbname);
    $db->set_charset('utf8mb4');
    $sql = "select * from user_info";

    $result = $db->query($sql);
    $data = [];
    while ($row = $result->fetch_object()) {
        if(isset($row->headphoto)) {
            $mime_type = (new finfo(FILEINFO_MIME_TYPE))->buffer($row->headphoto);
            $base64 = base64_encode($row->headphoto);
            $row->headphoto = "data:${mime_type};base64,${base64}";
        }
        $data[] = $row;
    }
    $myjson = json_encode($data, JSON_UNESCAPED_UNICODE);
    echo $myjson;

    // $stmt =$db->query($sql);
    # fetchAll(PDO::FETCH_ASSOC) fetchAll 是拿全部的陣列  PDO::FETCH_ASSOC 是只顯示KEY是欄位名稱跟value
    #預設顯示兩個 1.KEY是欄位名稱跟value   2.KEY是索引值跟value 
    
    // $result = array_map(function($row){
    //     // 找副檔名
    //     $mime_type = (new finfo(FILEINFO_MIME_TYPE))->buffer($row['pet_headphoto']);
    //     // 圖片檔轉字串
    //     $base64 = base64_encode($row['pet_headphoto']);
    //     $row['pet_headphoto'] = "data:${mime_type};base64,${base64}";
    //     return $row;
    // }, $rows);

    // echo json_encode($result);
    
} catch (PDOExcaption $e){
    print($e);
}