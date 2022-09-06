<?php
  require "../products/productsDB.php";
  require_once "../consumer/consumerDB.php";

  //require "../consumer/consumerDB.php";
  //require "../market/marketUserDB.php";
  //require "UploadExImg.php";

  //READ and display the database content
  session_start();
  $consumer = $_SESSION["user"];
  $district = $consumer["c_district"];
  $consumerCity = $consumer["c_city"];
  //var_dump($district);

  $user = getUser($consumer["c_email"]);

  if(!isset($_SESSION["shopcard"]))
    $_SESSION["shopcard"] = [];

  // $_SERVER["REQUEST_METHOD"] === "POST" && 
  if( isset($_GET["card"]) ){
    $card = $_GET["card"];
    //array_push($_SESSION["shopcard"], $card);

    if( !key_exists($card, $_SESSION["shopcard"]) ){
      $_SESSION["shopcard"] += [$card => 1];
    } else{
      $cnt = (int)($_SESSION["shopcard"][$card]);
      $_SESSION["shopcard"][$card] = $cnt + 1;
    }
  }
/*
  try{
    $stmt = $inventory_db->query("SELECT * FROM products, market_user WHERE products.market = market_user.m_email and market_user.m_district = '$district' "); 
    $products_district = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($products_district);
  }catch(PDOException $ex){
    errorPage();
  }

  try{
    $stmt = $inventory_db->query("SELECT * FROM products, market_user WHERE products.market = market_user.m_email and market_user.m_city = '$consumerCity' and  market_user.m_city != '$district'"); 
    $products_city = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($products);
  }catch(PDOException $ex){
    errorPage();
  }
  //var_dump( $_SESSION["shopcard"]);
  //$_SESSION["shopcard"] = [];

  $array_products = array_merge($products_district, $products_city );
  //var_dump($array_products);*/


  try{
    $stmt = $inventory_db->query("SELECT * FROM products, market_user WHERE products.market = market_user.m_email"); 
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($products);
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
  <title>Consumer</title>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.slim.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.js"></script>
  <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.js"></script>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.css" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">

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
  .img{
    width: 200px;
    height: auto;
  }
</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
  <a class="navbar-brand update"  href="../consumer/consumerUserProfileUpdate.php">Update</a> 
  <a class="navbar-brand update"  href="../consumer/shoppingCard.php">ShoppingCard</a> 
  <a class="navbar-brand update" href="../consumer/consumerLogout.php">Logout</a>
  </div>
</nav>
<div class="jumbotron pt-6 ">
  <h1 class="display-4">Dear  <?= $user["c_name"] ?> </h1><br><br>
  <p class="lead texts">Add as many products as you want to your Shopping Card to purchase </p>
  <hr class="my-4">
  <p class="texts">Do not forget that products are listed according to your district and the city. </p>
</div>

<h1>Products</h1>

<form action="" method="post" enctype="multipart/form-data">
    <table class="product">
      <tr>
        <td>
          <input type="text" name="keyword" placeholder="product name">
        </td>
        <td colspan>
          <button type="submit">SEARCH</button>
        </td>
      </tr>
    </table>
</form>

<table class="avaliable">
  <tr>
    <th>IMAGE</th>
    <th>TITLE</th>
    <th>STOCK</th>
    <th>NORMAL PRICE</th>
    <th>DISCOUNTED PRICE</th>
    <th>EXPIRATION DATE</th>
    <!-- <th>EXPIRATION IMAGE</th> -->
    <th>DISTRICT</th>
    <th>CITY</th>
    <th>ADD TO BASKET</th>
  </tr>

  <?php
    /*usort( $array_products, function($consumerCity, $second){
      var_dump($consumerCity);
      var_dump($second["m_district"]);
      return $consumerCity <=> $second["m_district"];
    });*/

    //var_dump($array_products);

    $productlist1 = [];
    $productlist2 = [];

    foreach ( $products  as $product) : 

      if(isset($_POST["keyword"]))
        $keyword = $_POST["keyword"];
      else 
        $keyword="";
        
      $pattern = '/.*'. $keyword .'.*/i';
      if( preg_match($pattern, $product["title"]) === 1 && $consumerCity == $product["m_city"] ) : 
              $now = new DateTime();
              $exp = DateTime::createFromFormat("Y-m-d", $product["ex_date"]);
              $diff = $exp->diff($now);
              $days_left = $diff->days;
          if($now < $exp) :
          
  ?>
          <?php 
            if($district == $product["m_district"])
              array_push($productlist1, $product);
            else
              array_push($productlist2, $product);
          ?>
        <?php endif; ?>
      <?php endif; ?>
    <?php endforeach ?>


<?php 
  //var_dump($productlist1);
  //var_dump($productlist2);
?>

<?php foreach($productlist1 as $product):?>
<tr>
              <td><img class='img' src='../products/images_exp/<?= $product["ex_img"] ?>' /></td>
              <td><?= $product["title"] ?></td>
              <td><?= $product["stock"] ?></td>
              <td><?= $product["normal_price"] ?></td>
              <td><?= $product["discounted_price"] ?></td>
              <td><?= $days_left ?></td>
              <td><?=$product["m_district"]?></td>
              <td><?=$product["m_city"]?></td>
              <td>
                  <a href="?card=<?=$product['PID']?>" title="Add To Basket">
                      <i class="fa-solid fa-xmark"></i>
                  </a>                     
              </td>
         </tr>    
<?php endforeach ?>

<?php foreach($productlist2 as $product):?>
<tr>
              <td><img class='img' src='../products/images_exp/<?= $product["ex_img"] ?>' /></td>
              <td><?= $product["title"] ?></td>
              <td><?= $product["stock"] ?></td>
              <td><?= $product["normal_price"] ?></td>
              <td><?= $product["discounted_price"] ?></td>
              <td><?= $days_left ?></td>
              <td><?=$product["m_district"]?></td>
              <td><?=$product["m_city"]?></td>
              <td>
                  <a href="?card=<?=$product['PID']?>" title="Add To Basket">
                      <i class="fa-solid fa-xmark"></i>
                  </a>                     
              </td>
         </tr>    
<?php endforeach ?>
</table> 
<script>

    $(document).ready(function() {


    $(window).scroll(function() {    
        var scroll = $(window).scrollTop();

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