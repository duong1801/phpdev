<?php
require_once './functions.php';


$users = first('SELECT * sd FROM users');
echo '<pre>';
print_r($users);
echo '</pre>';

?>