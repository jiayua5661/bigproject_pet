<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$host = 'localhost';
$dbname = 'petdb';
$user = 'root';
$password = '';

// $getdata = file_get_contents('php://input');
// $data = json_decode($getdata, true);
// $pet_species = $data['pet_species'];
// $pet_weight = $data['pet_weight'];
// $pet_fur = $data['pet_fur'];
// $planid = $data['planid'];

$pet_species = $_REQUEST['pet_species'];
$pet_weight = $_REQUEST['pet_weight'];
$pet_fur = $_REQUEST['pet_fur'];
$planid = $_REQUEST['planid'];
$weight_range;

if($pet_species == '狗') {
    switch ($pet_weight) {
        case $pet_weight < 10 :
            $weight_range = '0010';
            break;
        case $pet_weight < 20 :
            $weight_range = '1020';
            break;
        case $pet_weight < 40 :
            $weight_range = '2040';
            break;
    }
} else {
    $weight_range = '0000';
}

try {

    $db = new PDO("mysql:host=${host};dbname=${dbname};charset=utf8mb4", $user);
    $sql = "select * from beauty_plan_price_time where pet_species = ? and weight_range = ? and pet_fur = ? and planid = ?";
    $stmt =$db->prepare($sql);
    $stmt->execute([$pet_species, $weight_range, $pet_fur, $planid]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    # fetchAll(PDO::FETCH_ASSOC) fetchAll 是拿全部的陣列  PDO::FETCH_ASSOC 是只顯示KEY是欄位名稱跟value
    #預設顯示兩個 1.KEY是欄位名稱跟value   2.KEY是索引值跟value 

    header('Content-Type: application/json');
    echo json_encode($rows);
    // echo json_encode(['error' => '55555']);

    // $response = [
    //     'price' => 50.0,
    //     'time' => '1 hour'
    // ];
    // // Return the response as JSON
    // header('Content-Type: application/json');
    // echo json_encode($response);
    
} catch (PDOException $e){
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}