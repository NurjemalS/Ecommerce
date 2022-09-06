<?php
  session_start();
  require "consumerDB.php" ;
  $userData = $_SESSION["user"] ;
  $user = getUser($_SESSION["user"]["c_email"]);
  //var_dump($user);

    if( !validSession()) {
        header("Location: consumerLoginRegister.php?error") ;
        exit ; 
    }

    if(isset($_POST["btnSaveChanges"])){
        extract($_POST);

        if(empty($name) || empty($city) || empty($district) || empty($address)){
            echo "<p class='error'> Please Fill Fields Properly!  </p>";
        }else{
            $name_san = filter_var( $name, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $city_san = filter_var( $city, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $district_san = filter_var( $district, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $address_san = filter_var( $address, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
            $stmt = $db->prepare("UPDATE consumer_user SET c_name = :c_name , c_city = :c_city, c_district = :c_district, c_address = :c_address WHERE c_email = :c_email") ;
            $stmt->execute([ "c_email" => $userData["c_email"], "c_name" => $name_san, "c_city" => $city_san,  "c_district" => $district_san, "c_address" => $address_san]) ;
            header("Location: ../products/productsConsumer.php") ;
            exit ;
        }
    }else if(isset($_POST["btnChnagePassword"])){
        header("Location: ../consumer/consumerChangePassword.php") ;
        exit ;
    }
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        .error{
	        font-weight: bold;
	        color: red;
	        font-size: large;
            text-align: center; 
        }

        #btnChnagePassword, #btnSaveChanges {
	     border-radius: 20px;
	     border: 1px solid #4bb4bf;
	     background-color: #4bb4bf;
	    color: #FFFFFF;
	    font-size: 12px;
	    font-weight: bold;
	    padding: 12px 45px;
	    letter-spacing: 1px;
	    text-transform: uppercase;
	    transition: transform 80ms ease-in;
        }

        h1{
	        color: #4bb4bf;
	        font-size: 44px;
	        font-weight: bold;
            text-align: center; 
        }

        .btns{
            display: flex;
            align-items: center;
            text-align: center;
            justify-content: center;
        }
        .input{
            width: 500px;
            padding: 12px 20px;
            margin: 5px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 20px;
        }

        .container{
            display: flex;
            align-items: center;
            text-align: center;
            justify-content: center;
        }
    
    </style>
</head>
<body>
    <h1>Update The Profile</h1>
    <form action="" method="post">
    <div class="container">
    <div>
        <div>
            <h3>Name</h3>
            <input type="text" name="name"  class="input" value="<?= isset($name) ? filter_var( $name , FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $user['c_name'] ?>">
        </div>
        <div>
            <h3>City</h3>
            <input type="text" name="city"   class="input" value="<?= isset($city) ? filter_var( $city, FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $user['c_city'] ?>" >
        </div>
        <div>
            <h3>District</h3>
            <input type="text" name="district"  class="input" value="<?= isset($district) ? filter_var( $district, FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $user['c_district'] ?>">
        </div>
        <div>
            <h3>Address</h3>
            <input type="text" name="address"  class="input" value="<?= isset($address) ? filter_var( $address, FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $user['c_address'] ?>">
        </div><br><br>
        <div class="btns">
            <div>
                <input type="submit" value="Save Changes" name="btnSaveChanges" id="btnSaveChanges">   
            </div><br>
            <div>
                <input type="submit" value="Change Password" name="btnChnagePassword"  id="btnChnagePassword" >   
            </div><br>
        </div>
        </div>
    </div>
    </form>

</body>
</html>