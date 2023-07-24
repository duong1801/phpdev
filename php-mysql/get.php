<?php


require_once './connect.php';

$sql = 'SELECT * FROM users WHERE id = :id';
$stmt =  $conn->prepare($sql);
$status = $stmt->execute(['id'=>3]);
$users = $stmt->fetch(PDO::FETCH_ASSOC);
echo '<pre>';
print_r($users);
echo '</pre>';