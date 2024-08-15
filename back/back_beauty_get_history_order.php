<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// 找歷史訂單
$host = 'localhost';
$dbname = 'happypet_DB';
$user = 'root';
$password = '';

$pid = $_REQUEST['pid'];
$date = $_REQUEST['date'];

try {

    $db = new PDO("mysql:host=${host};dbname=${dbname};charset=utf8mb4", $user);
    $sql = "select beauty_order.date ,beauty_plan.plan_title from beauty_order left join beauty_plan on beauty_order.planid = beauty_plan.planid where pid = ? and date < ?;";
    $stmt =$db->prepare($sql);
    $stmt->execute([$pid, $date]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    # fetchAll(PDO::FETCH_ASSOC) fetchAll 是拿全部的陣列  PDO::FETCH_ASSOC 是只顯示KEY是欄位名稱跟value
    #預設顯示兩個 1.KEY是欄位名稱跟value   2.KEY是索引值跟value 

    echo json_encode($rows);
    
} catch (PDOExcaption $e){
    print($e);
}