<?php
session_start();
require "consumerDB.php" ;
$userData = $_SESSION["user"] ;


  if( !validSession()) {
	  header("Location: consumerLoginRegister.php?error") ;
	  exit ; 
  }

  if(isset($_POST["btnSaveChanges"])){
	  extract($_POST);

	  if(empty($password) || empty($confirm_password)){
		  echo "<p class='error'> Please Fill Fields Properly!  </p>";
	  }else if($password != $confirm_password ){
		echo "<p class='error'> Do not match </p>";
	  }else{
		  $reg_pass = '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/' ;
		  if(preg_match($reg_pass, $password) === 0){
			echo "<p class='error'> NOT a strong Passoword. Please follow the passoword guidlines! </p>";
		  }else{
			$pass_san = filter_var( $password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$hashPass = password_hash($pass_san, PASSWORD_BCRYPT) ;
			
			$stmt = $db->prepare("UPDATE consumer_user SET c_password = :c_password WHERE c_email = :c_email") ;
			$stmt->execute([ "c_email" => $userData["c_email"], "c_password" => $hashPass]) ;
			header("Location: ../consumer/consumerLogout.php") ;
			exit ;
		  }
		
	  }
  }else if(isset($_POST["btnClose"])){
	  header("Location: ../products/productsConsumer.php") ;
	  exit ;
  }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title >Change Password</title>
	<link rel="stylesheet" href="../style/passwordChange.css">
	<style>

	.error{
    	font-weight: bold;
    	color: red;
    	font-size: large;
		text-align: center; 
		margin-top: 20px;
	}
	</style>
</head>
<body>

<div>
     <h2 >Change Password</h2>
	 <form action="" method="post">

	 <div class="body">
	    <div class="left">
		 	<div class="passwords">
			    <div class="pass">
				   	<label for="password"><b>Password </b></label>
                     <input type="password" name="password" placeholder="Enter Password" id="password">
			    </div>
				<div class="pas_confirm">
				    	<label for="confirm-password"><b> Confirm Password </b> </label>
                     	<input type="password" name="confirm_password" placeholder="Confirm Your Password" id="confirm-password">
				</div>
			 </div>
		 </div>


		 <div class="right">

		    <div class="password-guidelines">
						<h3 class="guidelines-header">Password Guidelines</h3>
						<h4 class="guidelines-sub-header">Eg: MY@password123</h4>
						<div class="guidelines-description">
						<p>Must be 6 - 15 character</p>
						<p>Must include at least 1 UpperCase Letter</p>
						<p>Must include at least 1 UpperCase Letter</p>
						<p>Must include at least 2 Digit</p>
						
			</div>
		 </div>
	 </div>
	</div><br><br>
	<div class="btns">
		<input type="submit" value="Close" name="btnClose" id="btnClose">   
		<input type="submit" value="Save Changes" name="btnSaveChanges" id="btnSaveChanges"> 
	</div>
	
</form>

</body>
</html>