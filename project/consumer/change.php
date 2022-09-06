<?php
 session_start();
 require "consumerDB.php" ;
 $userData = $_SESSION["user"] ;
 var_dump($userData);

 if ( !empty($_POST)) {
    //var_dump($_POST) ;
    //var_dump($_FILES) ;
    require "consumerDB.php" ;

    extract($_POST) ;

    if($password != $confirm_password ){
        echo "<div class= 'match_error'> Passwords do NOT match. Try again <div>";
    }

    $hashPass = password_hash($password, PASSWORD_BCRYPT) ;

    $sql = "INSERT INTO consumer_user1 (email, name_con, city, district, address_con, password_con) values (?,?,?,?,?,?)";
    $stmt = $db->prepare($sql) ;
    $res = $stmt->execute([ $userData["email"],  $userData["name_con"],  $userData["city"],  $userData["district"],  $userData["address_con"], $hashPass]) ;
    header("Location: consumerLogin.php") ;
    exit ;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        New Password : <input type="password" name="pass" ><br><br>  

        <button type="submit">Register</button>

    </form>
</body>
</html>