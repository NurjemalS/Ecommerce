<?php 
require "../products/productsDB.php";
session_start();
var_dump( $_SESSION["shopcard"] );

try{
    $stmt = $inventory_db->query("SELECT * FROM products, market_user WHERE products.market = market_user.m_email"); 
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($products);
  }catch(PDOException $ex){
    errorPage();
  }
  if($_SERVER["REQUEST_METHOD"] === "GET"){
      extract($_GET);

      if(isset($del)){
        unset( $_SESSION["shopcard"][$del] );
        header("Location: shoppingCard.php");
      }

      if(isset($id)){
        $cnt = (int)($_SESSION["shopcard"][$id]);

        if($amount == 1){
          if($cnt == 1)
            unset( $_SESSION["shopcard"][$id] );
          else $_SESSION["shopcard"][$id] = $cnt - 1;
        }
          else
              $_SESSION["shopcard"][$id] = $cnt + 1;
        header("Location: shoppingCard.php");
      }

      if(isset($buy)){
        //UPDATE products in inventory
        try{
          foreach($_SESSION["shopcard"] as $key => $val){
            $finder = $inventory_db->prepare("SELECT stock FROM products WHERE PID = ?");
            $finder->execute([$key]);
            $stock = (int)(($finder->fetch(PDO::FETCH_ASSOC))['stock']);
            //var_dump($key);
            //var_dump($val);
            //var_dump($stock);
            
            $stmt = $inventory_db->prepare("UPDATE products SET stock = $stock-$val WHERE PID = ?"); // prepare
            $stmt->execute([$key]);
          }
        }catch(PDOException $ex){
          errorPage();
        }
        finally{
          $_SESSION["shopcard"] = [];
          header("Location: shoppingCard.php");
        }
      }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShoppingCard</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.slim.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.js"></script>
  <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.js"></script>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.css" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
</head>
  <style>
 
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
      text-decoration: none;
    }
    a:hover{
        color: black;
        font-weight: bold;
        text-decoration: none;
    }
    .plus-minus-btn {
    width: 33px;
    text-align: left;
    border:1px solid #9A9;
    background: #ADA ;
    border-radius: 20px;
    color: #696;
    text-decoration: none;
    display:inline-block;
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
  </style>

<style>
    body{background-color: sandybrown;}
</style>
<body>
    <h1>shoppingCard</h1>
    
<table class="avaliable">
  <tr>
    <th>TITLE</th>
    <th>STOCK</th>
    <th>NORMAL PRICE</th>
    <th>DISCOUNTED PRICE</th>
    <th>EXPIRATION DATE</th>
    <!-- <th>EXPIRATION IMAGE</th> -->
    <th>FUNCTIONS</th>
    <th>DELETE</th>
  </tr>

  <?php
    $sum = 0;
    foreach ($products as $product) : 
        $now = new DateTime();
        $exp = DateTime::createFromFormat("Y-m-d", $product["ex_date"]);
        $diff = $exp->diff($now);
        $days_left = $diff->days;
        if( in_array($product["PID"], array_keys($_SESSION["shopcard"])) ) :
            $index = array_search( $product["PID"], array_keys($_SESSION["shopcard"]) );
            $pid = $product["PID"];
            //$_SESSION["shopcard"][$index];
    ?>
        <tr>
            <td><?= $product["title"] ?></td>
            <td><?= $product["stock"] ?></td>
            <td><?= $product["normal_price"] ?></td>
            <?php $sum += $product["normal_price"] * $_SESSION["shopcard"][$pid]; ?>
            <td><?= $product["discounted_price"] ?></td>
            
            <td><?= $days_left ?></td>
            <td>
                <a href="?amount=<?= 2?>&id=<?=$pid?>" class="plus-minus-btn">+</a><br>
                <span class="amount"><?= $_SESSION["shopcard"][$pid] ?></span><br>
                <a href="?amount=<?= 1?>&id=<?=$pid?>" class="plus-minus-btn">-</a>
            </td>
            <td>
                <a href="?del=<?= $pid ?>" title="Delete">
                    <i class="fa-solid fa-trash-can">DELETE</i>
                </a>
            </td>
            
            </tr>
    <?php endif; endforeach; ?>
</table>
<h3><?=$sum?></h3>
<a href="?buy=0" title="Delete">
  <i class="fab">PURCHASE</i>
</a>
<a href="../products/productsConsumer.php">GO BACK</a>
</body>
</html>