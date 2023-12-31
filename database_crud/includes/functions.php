<?php

require_once './includes/connect.php';



function query($sql, $data = [], $isSatus = true)
{
    global $conn;

    try{
        $statement = $conn->prepare($sql);
        $status =  $statement->execute($data);
        if ($isSatus) {
            return $status;
        }
        return $statement;
    }
    catch(PDOException $e){

        require_once './includes/error.php';
        die();
    }



}

function create($table, $data = [])
{

    if (!empty($data)) {

        $keys = array_keys($data);
        $sql = "INSERT INTO {$table} (" . implode(', ', $keys) . ") VALUES (" . ":" . implode(', :', $keys) . ")";


        $status = query($sql, $data, $isSatus = true);
        return $status;
    }
    return false;


}

function createGetId($table, $data = [])
{
    global $conn;
    $status = create($table, $data);
    if ($status) {
        $id = $conn->lastInsertId();
        return $id;
    }
    return false;
}

function update($table, $data = [], $condition = '')
{
    $keys = array_keys($data);
    $update = '';
    foreach ($keys as $index => $key) {
        $update .= $key.'=:'.$key.', ';
    }
    $update = rtrim($update,', ');

    $sql = "UPDATE {$table} SET ".$update." WHERE $condition";

    $status = query($sql, $data);

}

function get ($sql,$data = []){
    $statement = query($sql,$data, $isSatus = false);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function first ($sql,$data = []){
    $statement = query($sql,$data,  $isSatus = false);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function getRows ($sql,$data = []){
    $statement = query($sql,$data,$isSatus = false);
    return $statement-> rowCount();
}


function delete ($table,$condition){
    $sql = "DELETE FROM {$table} WHERE {$condition}";
    $status = query($sql);
    return $status;
}


function getDateFormat ($date,$format){
    $dateObj = date_create($date);
    return date_format($dateObj,$format);
}


function dd ($arr){
    echo "<pre>";
    print_r($arr);
    echo "<pre>";
}


function getOperator ($str){
    if(strpos($str,'WHERE')){
        return ' AND ';
    }
    return ' WHERE ';
}


function getPaginateUrl($page){
    $isPage = false;
    $currentIndex = null;
    $query = [];
    if (!empty($_SERVER['QUERY_STRING'])) {
        $query = explode('&', $_SERVER["QUERY_STRING"]);
       
        foreach ($query as $index => $item) {
            $itemArr = explode('=', $item);
            if ($itemArr[0] == "page") {
                $isPage = true;
                $currentIndex = $index;
                break;
            }
        }
    }
    if (!$isPage) {
        array_push($query, "page=" . $page);
    }
    else {
        $query[$currentIndex] = "page=" . $page;
    }
    return "?".implode('&', $query);
}
?>