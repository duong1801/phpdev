<?php


require_once './connect.php';
$data = [
    'name' =>"Huyền Anh",
    'phone'=>'8986778'
];
$sql = 'INSERT INTO users(name,phone) VALUES (:name,:phone)';
$stmt =  $conn->prepare($sql);
$check = $stmt->execute($data);
var_dump($check);