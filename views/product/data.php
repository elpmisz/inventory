<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
require_once(__DIR__ . "/../../includes/connection.php");
require_once(__DIR__ . "/../../vendor/autoload.php");

$user_id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "");

$stmt = $dbcon->prepare("SELECT COUNT(*) FROM item");
$stmt->execute();
$count = $stmt->fetchColumn();

$column = ["A.status", "A.name", "A.reference", "A.unit"];

$type = (isset($_POST['type']) ? intval($_POST['type']) : "");

$keyword = (isset($_POST['search']['value']) ? $_POST['search']['value'] : "");
$order = (isset($_POST['order']) ? $_POST['order'] : "");
$order_column = (isset($_POST['order']['0']['column']) ? $_POST['order']['0']['column'] : "");
$order_dir = (isset($_POST['order']['0']['dir']) ? $_POST['order']['0']['dir'] : "");
$limit_start = (isset($_POST['start']) ? $_POST['start'] : "");
$limit_length = (isset($_POST['length']) ? $_POST['length'] : "");
$draw = (isset($_POST['draw']) ? $_POST['draw'] : "");

$sql = "SELECT A.id item_id,CONCAT('[',A.id,'] ',A.name) item_name,A.unit item_unit,A.status item_status,
A.reference reference_id,B.name reference_name,
IF(A.status = 1,'รายละเอียด','ระงับการใช้งาน') status_name,
IF(A.status = 1,'success','danger') status_color
FROM item A 
LEFT JOIN item B
ON A.reference = B.id
WHERE A.id != ''  ";

if ($type) {
  $sql .= " AND A.type = {$type} ";
}


if ($keyword) {
  $sql .= " AND (A.name LIKE '%{$keyword}%' OR B.name LIKE '%{$keyword}%') ";
}

if ($order) {
  $sql .= "ORDER BY {$column[$order_column]} {$order_dir} ";
} else {
  $sql .= "ORDER BY A.status ASC, A.type ASC, A.reference ASC ";
}

$query = "";
if (!empty($limit_length)) {
  $query .= "LIMIT {$limit_start}, {$limit_length}";
}

$stmt = $dbcon->prepare($sql);
$stmt->execute();
$filter = $stmt->rowCount();
$stmt = $dbcon->prepare($sql . $query);
$stmt->execute();
$result = $stmt->fetchAll();

$data = [];
foreach ($result as $row) {
  $status = "<a href='/items/view/{$row['item_id']}' class='badge text-bg-{$row['status_color']} fw-lighter'>{$row['status_name']}</a>";
  $data[] = [
    "0" => $status,
    "1" => $row['item_name'],
    "2" => $row['reference_name'],
    "3" => $row['item_unit'],
  ];
}

$output = [
  "draw"    => $draw,
  "recordsTotal"  =>  $count,
  "recordsFiltered" => $filter,
  "data"    => $data
];

echo json_encode($output);
