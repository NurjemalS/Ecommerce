<?php 
    session_start();

    if(isset($_POST["btnVerify"])){
      
        extract($_POST) ;
        var_dump($c);
        var_dump((int)$c . "is entered ");

        if( $_SESSION["code"] == $c){
            header("Location: ../market/marketLoginRegister?auth=1.php") ;
            exit ;
        }else{
            echo "<p class='error'> Wrong code!  </p>";
        }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ConfirmConsumer</title>
    <style>
        #btnVerify{
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
        }

        .container{
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            width: 100%;
            text-align: center;
            min-height: 400px;
            
            align-items: center;

        }
        .inputCode{
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

      
.error{
	font-weight: bold;
	color: red;
	font-size: large;
}

    </style>
</head>
<body>
<form action="?" method="post">
    <div class="container">
    
    <div>
        <h1>Confirm The Code </h1>
    </div><br>
    <div>
        <p>
            Enter the security code sent to your email. Click the verify button to make sure it is configured correctly
        </p>
    </div>
    <div>
        <h2 >Verification Code</h2>
    </div><br>
    <div>
        <input type="text" name="c" placeholder="Verification Code" class="inputCode">
    </div><br>
    <div>
        <input type="submit" value="Verify" name="btnVerify" id="btnVerify">   
    </div><br>
</div>

</form>
    
    
</body>
</html>