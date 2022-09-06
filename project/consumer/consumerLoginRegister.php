<?php
  session_start();
  require "consumerDB.php" ;
  extract($_GET) ;

  if ( isset($_POST["btnSignin"])) {
      extract($_POST) ;

      if ( checkUser($email, $pass) ) {
          // you are authenticated
          // session_start() creates a random id called session id.
          // and stores in a cookie.

          $_SESSION["user"] = getUser($email) ;
          var_dump($_SESSION["user"])  ;
          header("Location: ../products/productsConsumer.php") ;
          exit ;
          //echo "you are here";
      }else{
        echo "<p class='error'> Wrong email or password</p>" ;
      }
      
  }else if(isset($_POST["btnSignup"])){
      
        extract($_POST) ;

        $isExist = userExist($email);
        echo "<p class='error'> User with the same email is already exist. Please try to sign up again!</p>";

        if( $isExist == 0){
            if(empty($email) || empty($pass) || empty($name) ||  empty($city) ||  empty($address) ||  empty($district)){
                echo "<p class='error'> Fill the all fields properly please! </p>";
            }else{
                $hashPass = password_hash($pass, PASSWORD_BCRYPT) ;
                //$sql = "INSERT INTO consumer_user (c_email, c_name, c_city, c_district, c_address, c_password) values (?,?,?,?,?,?)";
                //$stmt = $db->prepare($sql) ;
                //$res = $stmt->execute([$email, $name, $city, $district, $address, $hashPass]) ;
                 $_SESSION["email"]  =  $email;
                 $_SESSION["pass"]  =   $hashPass;
                 $_SESSION["name"]  = $name;
                 $_SESSION["city"]  =  $city;
                 $_SESSION["district"]  =  $district;
                 $_SESSION["address"]  =  $address;

                 $code = rand(100000,999999);
                 $_SESSION["code"]  = $code;
                 require_once './mail.php' ;
                 Mail::send($_SESSION["email"], "Authenticate your account", "Dear CONSUMER USER,<br> Vefification Code is  <b>" .$_SESSION["code"] . "</b> to authenticate your account.<br><br>Best wishes,<br>CTIS256 ") ;
             
                //var_dump($code . "  is generated");
                var_dump($_SESSION["email"]);
                var_dump($_SESSION["code"]. " is code in session file");
            
               
                header("Location: confirmConsumer.php") ;
                exit ;
            }
        
        }
  }

  if(isset($_GET["auth"]) && $_GET["auth"] == 1){
      //echo "ready to insert";
      $sql = "INSERT INTO consumer_user (c_email, c_name, c_city, c_district, c_address, c_password) values (?,?,?,?,?,?)";
      $stmt = $db->prepare($sql) ;
      $res = $stmt->execute([$_SESSION["email"],$_SESSION["name"], $_SESSION["city"] , $_SESSION["district"], $_SESSION["address"],  $_SESSION["pass"]]) ;
  }

  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../style/loginRegister.css">

</head>
<body>



    <div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="?" method="post">
			<h1>Create Account</h1><br><br>
			
			<input type="email" name="email"  placeholder="Email" />
            <input type="text" name="name" placeholder="Name" />
            <input type="text" name="city" name="city" placeholder="City" />
            <input type="text" name="district" placeholder="District"  >
            <input type="text" name="address"  placeholder="Adress" >
			<input type="password"  name="pass"  placeholder="Password" /><br><br>
            <input type="submit" value="Sign Up" name="btnSignup" id="btnSignup">   
			
    </form>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form action="" method="post">
			<h1>Sign in</h1><br><br>
			<input type="email" name="email" placeholder="Email" />
			<input type="password" name="pass" placeholder="Password" /><br><br>
            <input type="submit" value="Sign In" name="btnSignin" id="btnSignin">   
	
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello, Consumer!</h1>
				<p>Enter your personal details and start journey with us</p>
				<button class="ghost" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>

    <?php
      if ( isset($_GET["error"])) {
          echo "<p>You tried to access main.php directly</p>" ;
      }

    ?>

<script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => {
	    container.classList.add("right-panel-active");
       });

        signInButton.addEventListener('click', () => {
	    container.classList.remove("right-panel-active");
        });
</script>


</body>
</html>