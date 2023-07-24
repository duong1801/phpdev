<?php


// Các cấp độ errors


/*
 * 1 notice
 * 2 warning
 * 3 errors
 */


// Xử lý ngoại lệ

try {
    echo a();
}
catch (Error $e) {
    echo $e->getMessage();
}
echo "<h1>Hello!</h1>";