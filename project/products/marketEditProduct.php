<?php
   require "../products/productsDB.php";
   require "../products/UploadExImg.php";
 
   require "../market/marketUserDB.php";
 
   //start the session here
   session_start();
   $marketUser = $_SESSION["user"];
   $email = $marketUser["m_email"];
   $PID = $_GET["id"];
   $productDB = getProduct($PID);
   //var_dump($PID);
   //var_dump($marketUser);
   //var_dump($productDB);

if(!empty($_POST)){

    extract($_POST);
    $error = []; 

    $ex_img = new UploadExImg("ex_img","images_exp");
    $filename = $ex_img->file();
    $error_img =  $ex_img->error();
    //var_dump( $error_img);
    //var_dump($filename);

    if($error_img === "No file uploaded"){
      //echo "here";
      $error["error"]["No file uploaded"] = "No file uploaded";
    }
 
    
    //Error array for user inputs!
  
    if(filter_var($stock, FILTER_VALIDATE_INT, ['options' => ['min_range' => 10]]) === false){
      $error["error"]["invalid stock"] = "invalid stock";
    }

    if(filter_var($normal_price, FILTER_VALIDATE_FLOAT, ['options' => ['min_range' => 0]]) === false){
      $error["error"]["invalid normal price"] = "invalid normal price";
    }

    if(filter_var($discounted_price, FILTER_VALIDATE_FLOAT, ['options' => ['max_range' => $normal_price]]) === false){
      $error["error"]["invalid discounted price"] = "invalid discounted price";
    }

    if($discounted_price>$normal_price){
      $error["error"]["invalid discounted price"] = "invalid discounted price";
    }

    if(empty($title)){
      $error["error"]["invalid title name"] = "invalid title name";
    }

    // prevent the possible attacks
    $sanitized_title = filter_var($title, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sanitized_stock = filter_var($stock, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sanitized_normal_price = filter_var($normal_price, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sanitized_discounted_price = filter_var($discounted_price, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $sanitized_ex_date = filter_var($ex_date, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(empty($error)){
        try{
            $stmt = $inventory_db->prepare("UPDATE products 
                                            SET title= :title, stock= :stock, 
                                            normal_price= :normal_price, 
                                            discounted_price= :discounted_price, 
                                            ex_date= :ex_date, ex_img= :ex_img
                                            WHERE PID = :PID");
      
            $stmt->execute(["PID" => $PID, 
                            "title" => $sanitized_title, 
                            "stock" => $sanitized_stock, 
                            "normal_price" =>$sanitized_normal_price , 
                            "discounted_price" => $sanitized_discounted_price, 
                            "ex_date" => $ex_date, 
                            "ex_img" => $filename]);
        //header("Location: productsMarket.php?edit=$PID");
        //exit;
        header("Location: ../products/productsMarket.php") ;
        exit ;
         
        }catch(PDOException $ex){
          errorPage();
        }    
    }
}

 // get the product by its stock id

$product = getProduct($PID);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product</title>
  <style>
        .error{
	        font-weight: bold;
	        color: red;
	        font-size: large;
          text-align: center; 
        }

       #btnSaveChanges {
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
<h1>Edit Product</h1>
<?php 
    if(!empty($error)){
      foreach($error["error"] as $err){
        echo "<p  class='error' >". $err;
      }
    }

?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="container">
    <div>
        <div>
            <h3>TITLE</h3>
            <input type="text" name="title" class="input" value="<?= isset($title) ? filter_var($title, FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $productDB['title'] ?>">
        </div>
        <div>
            <h3>STOCK</h3>
            <input type="text" name="stock" class="input" value="<?= isset($stock) ? filter_var($stock, FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $productDB['stock'] ?>">
        </div>
        <div>
            <h3>NORMAL PRICE</h3>
            <input type="text" name="normal_price" class="input" value="<?=  isset($normal_price) ? filter_var( $normal_price, FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $productDB['normal_price']  ?>" >
        </div>
        <div>
            <h3>DISCOUNTED PRICE</h3>
            <input type="text" name="discounted_price" class="input" value="<?=  isset($discounted_price) ? filter_var($discounted_price, FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $productDB['discounted_price']  ?>" >
        </div>
        <div>
            <h3>EXPIRATION DATE</h3>
            <input type="date" name="ex_date" class="input" value="<?=  isset($ex_date) ?  filter_var($ex_date, FILTER_SANITIZE_FULL_SPECIAL_CHARS): $productDB['ex_date'] ?>" >
        </div>
        <div>
            <h3>EXPIRATION IMAGE</h3>
            <input type="file" name="ex_img" class="input" >
        </div><br><br>


        <div class="btns">
            <div>
                <input type="submit" value="Save Changes" name="btnSaveChanges" id="btnSaveChanges">   
            </div><br>
        </div>
      </div>
    </div>
  </form>   





















<!--<form action="" method="post"  enctype="multipart/form-data" >
    <table>
      <tr>
        <td>ID</td>
        <td>
          <?= $product["PID"] ?>
          <input type="hidden" name="PID" value="<?= $product["PID"] ?>">
        </td>
      </tr>
      <tr>
        <td>TITLE</td>
        <td>
          <input type="text" name="title" value="<?= $product["title"] ?>">
        </td>
      </tr>
      <tr>
        <td>STOCK</td>
        <td>
          <input type="text" name="stock" value="<?= $product["stock"] ?>">
        </td>
      </tr>
      <tr>
        <td>NORMAL PRICE</td>
        <td>
          <input type="text" name="normal_price" value="<?= $product["normal_price"] ?>">
        </td>
      </tr>
      <tr>
        <td>DISCOUNTED PRICE</td>
        <td>
          <input type="text" name="discounted_price" value="<?= $product["discounted_price"] ?>">
        </td>
      </tr>
      <tr>
        <td>EXPIRATION DATE</td>
        <td>
          <input type="date" name="ex_date" value="<?= $product["ex_date"] ?>">
        </td>
      </tr>
      <tr>
        <td>EXPIRATION IMAGE</td>
        <td>
          <input type="file" name="ex_img" placeholder="EXPIRATION IMAGE" >
        </td>
      </tr>
    </table>
    <input type="submit" value="Save Changes" name="btnSaveChanges" id="btnSaveChanges">   

    <div class="center">
      <button type="submit" class="btn edit">
        <i class="fa-solid fa-rotate">Save Changes</i>
      </button> 
    </div> -->
  </form>
</body>
</html>