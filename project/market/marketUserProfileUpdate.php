<?php
  session_start();
  require "marketUserDB.php" ;
  $userData = $_SESSION["user"] ;
  $user = getUser($_SESSION["user"]["m_email"]);
//var_dump($user);
//var_dump($userData);

    if( !validSession()) {
        header("Location: marketLoginRegister.php?error") ;
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
        
            $stmt = $db->prepare("UPDATE market_user SET m_name = :m_name , m_city = :m_city, m_district = :m_district, m_address = :m_address WHERE m_email = :m_email") ;
            $stmt->execute([ "m_email" => $userData["m_email"], "m_name" => $name_san, "m_city" => $city_san,  "m_district" => $district_san, "m_address" => $address_san]) ;
            header("Location: ../products/productsMarket?name=$name_san") ;
            exit ;
        }
    }else if(isset($_POST["btnChnagePassword"])){
        header("Location: ../market/marketChangePassword.php") ;
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
            <input type="text" name="name"  class="input" value="<?= isset($name) ? filter_var( $name, FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $user['m_name']?>">
        </div>
        <div>
            <h3>City</h3>
            <input type="text" name="city"   class="input" value="<?= isset($city) ? filter_var( $city, FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $user['m_city'] ?>" >
        </div>
        <div>
            <h3>District</h3>
            <input type="text" name="district"  class="input" value="<?= isset($district) ? filter_var( $district, FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $user['m_district'] ?>">
        </div>
        <div>
            <h3>Address</h3>
            <input type="text" name="address"  class="input" value="<?= isset($address) ? filter_var( $address, FILTER_SANITIZE_FULL_SPECIAL_CHARS)  : $user['m_address']?>">
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