<?php
require_once './includes/functions.php';
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Database CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/main.css">
</head>
<body>
<div class="container my-4 text-center">
    <?php

        if(!empty($_GET['actions'])){
            $actions = $_GET['actions'];
        }else {
            $actions = 'list';
        }

        $path = "./actions/".$actions.".php";
       require_once $path;
    ?>
</div>
</body>
</html>