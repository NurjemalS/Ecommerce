<?php
  require "../products/productsDB.php";
  require "../products/UploadExImg.php";

  require "../market/marketUserDB.php";

  //start the session here
  session_start();
  $marketUser = $_SESSION["user"];
  $email = $marketUser["m_email"];
  //var_dump($marketUser);
  $user = getUser($email);
//var_dump($marketUser);

  //DELETE products from inventory
  if(isset($_GET["delete"])){
    $id = $_GET["delete"];
    $product = getProduct($id);
    try{
      $stmt = $inventory_db->prepare("DELETE FROM products WHERE PID = ?");
      $stmt->execute([$id]);
    }catch(PDOException $ex){
      errorPage();
    }
  }

  //ADD product to the inventory
  if(!empty($_POST)){
    $error = []; 
    extract($_POST);

    $exp_img = new UploadExImg("ex_img","images_exp");
    $filename = $exp_img->file();
    $error_img =  $exp_img->error();
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

    $sql = "INSERT INTO products (market, title, stock, normal_price, discounted_price, ex_date, ex_img) VALUES (?,?,?,?,?,?,?)";
    
    if(empty($error)){
      $stmt = $inventory_db->prepare($sql);
      $stmt->execute([$email , $sanitized_title, $stock, $normal_price, $discounted_price, $ex_date, $filename]);
     // var_dump($filename);
      //var_dump( $exp_img);
      header("Location: ../products/productsMarket.php") ;
      exit ;
    }

  }

  //Read and Display the inventory
  try{
    $stmt = $inventory_db->query("SELECT * FROM products WHERE market = '$email' ");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // $stmt = $inventory_db->prepare("SELECT * FROM products WHERE market = ? ");
    // $res = $stmt->execute([$email]);
    // var_dump($res);
    // $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }catch(PDOException $ex){
    errorPage();
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory</title>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.slim.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.js"></script>
  <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.js"></script>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.css" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="..products/product.css">
<style>
  @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css');
    h1{
      text-align: center;
    }
    table{
      border-collapse: collapse;
      margin: 30px auto;
    }
    tr, th, td{
      padding: 10px;
      border: 1px solid #ddd;
    }
    a{
      padding: 10px;
    }

    .jumbotron {
    position: relative;
    background: none;
    }

    .jumbotron:after {
    content: "";
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    background-image: url("../images/home.jpeg");
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;

    width: 100%;
    height: 400px;
    opacity: 0.6;
    z-index: -1;
    }

    /* product.css */
  h1{
    color: #4bb4bf;
    font-size: 80px;
    font-weight: bold;
  }
  .update{
    border-radius: 20px;
    border: 1px solid #4bb4bf;
    background-color: #4bb4bf;
    color: #FFFFFF;
    font-size: 15px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in;
  }
  .texts{
    font-size: 18px;
    font-weight: bold;
  }
  @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css");
  h1 {
    text-align: center;
  }
  table {
    border-collapse: collapse;
    margin: 30px auto;
  }
  tr,
  th,
  td {
    padding: 10px;
    border: 1px solid #ddd;
  }
  a {
    padding: 10px;
  }

  .product {
    font-weight: bold;
  }

  .strike-through {
    color: red;
    font-style: oblique;
    text-decoration: line-through;
  }

  .center {
    display: grid;
    justify-items: center;
  }

  .edit {
    background: blueviolet;
    color: aliceblue;
    width: 50px;
    height: 50px;
  }

  .error {
    background-color: rgba(185, 99, 99, 0.4);
    color: black;
    font-size: 20px;
    text-align: center;
  }

  .pages > * { margin-right: 5px; margin-left:5px;}
      .pages span {  padding: 5px; color: red; font-weight: bold ; background: #9F9;}
      .pages a { text-decoration: none;}
      .pages { text-align: center; margin-top: 30px;}


  .img{
    width: 200px;
    height: auto;
  }

</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <a class="navbar-brand update"  href="../market/marketUserProfileUpdate.php">Update</a> 
    <a class="navbar-brand update"  href="../market/marketLogout.php">Logout</a>
</nav>

<div class="jumbotron pt-6 ">
  <h1 class="display-4">Dear <?= $user["m_name"] ?> </h1><br><br>
  <p class="lead texts">Add as many products as you want by filling the fields with right data of your inventory. </p>
  <hr class="my-4">
  <p class="texts">Do not forget that all expired products will be market automatically by the system. </p>
</div>

<h1>Products</h1>
  <!-- multipart/form-data -->
  <?php 
    extract($_POST);
    
    if(!empty($error)){
      foreach($error["error"] as $err){
        echo "<p  class='error' >". $err;
      }
    }
  ?>
  
  <form action="" method="post" enctype="multipart/form-data">

    <!-- first table is for adding a new product to the inventory -->
    <table class="product">
      <tr>
        <td>
          <input type="text" name="title" placeholder="TITLE" value="<?= isset($title) ? $title: ''?>" >
        </td>

        <td>
          <input type="text" name="stock" placeholder="STOCK" value="<?= isset($stock) ? $stock : ''?>" >
        </td>
      
        <td>
          <input type="text" name="normal_price" placeholder="NORMAL PRICE" value="<?= isset($normal_price) ? $normal_price : '' ?>">
        </td>

        <td>
          <input type="text" name="discounted_price" placeholder="DISCOUNTED PRICE" value="<?= isset($discounted_price) ? $discounted_price : '' ?>" >
        </td>

        <td>
          <input type="date" name="ex_date" placeholder="EXPIRATION DATE" value="<?= isset($ex_date) ? $ex_date : '' ?>" >
        </td>

        <td>
          <input type="file" name="ex_img" placeholder="EXPIRATION IMAGE" value="<?= isset($ex_img) ? $ex_img : '' ?>" >
        </td>

        <td>
          <button type="submit">ADD</button>
        </td>
      
      </tr>
    </table>

    <!-- second table is for avaliable products -->
    <table class="avaliable">
      <tr>
        <th>TITLE</th>
        <th>STOCK</th>
        <th>NORMAL PRICE</th>
        <th>DISCOUNTED PRICE</th>
        <th>EXPIRATION DATE</th>
        <th>EXPIRATION IMAGE</th>
        <th>FUNCTIONS</th>
      </tr>

      <?php
            usort($products, function($first, $second){
                return $first["ex_date"] <=> $second["ex_date"];
            });
      ?>

      <?php
      //PAGING
      $page = $_GET["page"] ?? 1;
      const PS = 3; // page size
      $size = count($products); // size of the products array
      $totalPage = ceil($size / PS); // calculate the total page
      $start = ($page - 1) * PS;  // start index
      $end = $start + PS;  // end index
      $end = $end > $size ? $size : $end; // end index cannot be greater than size of the array
      for ($i = $start; $i < $end; $i++) {
        
        $product = $products[$i];
        $now = new DateTime();
        $exp = DateTime::createFromFormat("Y-m-d", $product["ex_date"]);
        //$diff = $now->diff($exp);
        //$days_left = $diff->y*365 + $diff->m*30 + $diff->days;

        //$date1=date_create("2022-05-15");
        //$date2=date_create("2022-05-10");
        $diff=date_diff($now,$exp);
        $days_left = $diff->format("%R%a");

        /*echo $days_left;
        var_dump( $now );
        echo "now";
        var_dump($exp);
        echo " given";
        var_dump($diff );
        echo  $diff->y*365;
        echo $diff->m*30;
        echo $diff->days;*/

        if($days_left <= 0){
          echo "<tr class='strike-through'>";
        }
        else{
          echo "<tr>";
        }

        echo "<td>{$product["title"]}</td>";
        echo "<td>{$product["stock"]}</td>";
        echo "<td>{$product["normal_price"]}</td>";
        echo "<td>{$product["discounted_price"]}</td>";
        
        if($days_left <= 0){
          echo "<td>{$days_left} days passed!</td>";
        }
        else{
          echo "<td>{$days_left} days left!</td>";
        }
        //echo "<td>{$days_left} days left!</td>";
        echo"<td><img class='img' src='../products/images_exp/". $product["ex_img"] ."' /><td>";
        
        
        echo "<a href='?delete=" . $product["PID"] ."' title='Delete'>";
        echo "<i class='fa-solid fa-trash-can'></i>";
        echo "</a>";
        echo "<a href='marketEditProduct.php?id=" . $product["PID"] . "' title='Edit'>";
        echo "<i class='fa-solid fa-pen'></i></i>";
        echo "</a>";                     
        
        echo "</tr>";
      }

      ?>
    </table>  
  </form>

  <!-- PAGING -->
  <div class="pages">[
    <?php
      for ($i=1; $i<= $totalPage; $i++) {
          if ( $i == $page) {
            echo "<span>$i</span>" ;
          } else {
            echo "<a href='?page=$i'>$i</a>" ;
          }
      }
    ?>
  ]</div>



<script>

$(document).ready(function() {


$(window).scroll(function() {    
    var scroll = $(window).scrollTop();

     //>=, not <=
    if (scroll >= 60) {
        //clearHeader, not clearheader - caps H
        $(".navbar").addClass("bg-light");
    } else {
      $(".navbar").removeClass("bg-light");
    }
}); //missing );
  
// document ready  
});
</script>

</body>
</html>