<?php
require_once 'config.php';

if (class_exists('PDO')) {
    try {
        $dns = DRIVER . ':dbname=' . DB . ';host=' . HOST;
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', //Hỗ trợ tiết việt
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Lỗi ngoại lệ khi gặp lỗi truy vấn sai ( Sai câu lệnh sql )
        ];
        $conn = new PDO(
            $dns, USER, PASSWORD,$options
        );

    } catch (PDOException $e) {

        require_once './includes/error.php';
        die();
    }
}

?>