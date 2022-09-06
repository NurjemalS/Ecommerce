<?php

$dsn = "mysql:host=localhost;dbname=test;charset=utf8mb4" ;
$user ="std";
$pwd = "";

try{
  $inventory_db = new PDO($dsn, $user, $pwd);
}catch(PDOException $ex){
  echo "Service is down!";
}


function getProduct($id)
{
  global $inventory_db;
  try {
    $stmt = $inventory_db->prepare("SELECT * FROM products WHERE PID = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $ex) {
    errorPage();
  }
}

function errorPage(){
  header("Location: error.php");
  exit;
}


?>