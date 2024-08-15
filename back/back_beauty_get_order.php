<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$host = 'localhost';
$dbname = 'happypet_DB';
$user = 'root';
$password = '';

$first_date = $_REQUEST['first_date'];
$last_date = $_REQUEST['last_date'];

try {

    $db = new PDO("mysql:host=${host};dbname=${dbname};charset=utf8mb4", $user);
    $sql = "select beauty_order.boid, beauty_order.pid , beauty_order.start_time, beauty_order.use_time, beauty_order.end_time, beauty_plan.plan_title, pet_info.pet_name,pet_info.pet_birthday,
        pet_info.others, user_info.name, user_info.cellphone, pet_info.pet_headphoto
        from beauty_order 
        LEFT JOIN pet_info ON beauty_order.pid = pet_info.pid
        left join beauty_plan on beauty_order.planid = beauty_plan.planid
        left join user_info on beauty_order.uid = user_info.uid where date between ? and ?";
    $stmt =$db->prepare($sql);
    // $stmt =$db->query($sql);
    $stmt->execute([$first_date, $last_date]);
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