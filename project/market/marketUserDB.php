<?php

const DSN = "mysql:host=localhost;dbname=test;charset=utf8mb4" ;
const USER = "root" ;
const PASSWORD = "root" ;

 $db = new PDO(DSN, USER, PASSWORD) ;
 
 function checkUser($email, $pass) {
     global $db ;

     $stmt = $db->prepare("select * from market_user where m_email=?") ;
     $stmt->execute([$email]) ;
     if ( $stmt->rowCount()) {
         $user = $stmt->fetch(PDO::FETCH_ASSOC) ;
         return password_verify($pass, $user["m_password"]) ;
     }
     return false ;
 }

 function validSession() {
     return isset($_SESSION["user"]) ;
 }

 function getUser($email) {
     global $db ;
     $stmt = $db->prepare("select * from market_user where m_email=?") ;
     $stmt->execute([$email]);
     return $stmt->fetch(PDO::FETCH_ASSOC) ;
 }

 function userExist($email) {
    global $db ;
    $stmt = $db->prepare("select * from market_user where m_email=?") ;
    $stmt->execute([$email]);

    $res =  $stmt->fetch(PDO::FETCH_ASSOC) ;
    if(empty($res)){
        return 0;
    }else{
        return 1;
    }
}

function getUserById($id) {
    global $db ;
    $stmt = $db->prepare("select * from market_user where m_id=?") ;
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ;
}
