<?php

const DSN = "mysql:host=localhost;dbname=test;charset=utf8mb4" ;
const USER = "std" ;
const PASSWORD = "" ;

 $db = new PDO(DSN, USER, PASSWORD) ;
 
 function checkUser($email, $pass) {
     global $db ;

     $stmt = $db->prepare("select * from consumer_user where c_email=?") ;
     $stmt->execute([$email]) ;
     if ( $stmt->rowCount()) {
         $user = $stmt->fetch(PDO::FETCH_ASSOC) ;
         return password_verify($pass, $user["c_password"]) ;
     }
     return false ;
 }

 function validSession() {
     return isset($_SESSION["user"]) ;
 }

 function getUser($email) {
     global $db ;
     $stmt = $db->prepare("select * from consumer_user where c_email=?") ;
     $stmt->execute([$email]);
     return $stmt->fetch(PDO::FETCH_ASSOC) ;
 }

 function userExist($email) {
    global $db ;
    $stmt = $db->prepare("select * from consumer_user where c_email=?") ;
    $stmt->execute([$email]);

    $res =  $stmt->fetch(PDO::FETCH_ASSOC) ;
    if(empty($res)){
        return 0;
    }else{
        return 1;
    }
}