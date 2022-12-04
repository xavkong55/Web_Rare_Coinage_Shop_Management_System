<?php
  include_once 'database.php';
  if (!isset($_SESSION['loggedin']))
  header("Location: logout.php");
?>
 
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Rare Coinage Shop : Products Details</title>
  <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
 
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<style type="text/css">
</style>
<body>
 
<?php include_once 'nav_bar.php'; ?>
 
<?php
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM tbl_products_a176252_pt2 WHERE FLD_PRODUCT_ID = :pid");
  $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
    $pid = $_GET['pid'];
  $stmt->execute();
  $readrow = $stmt->fetch(PDO::FETCH_ASSOC);
  }
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
 
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-5 col-sm-offset-1 col-md-4 col-md-offset-2 well well-sm text-center">
      <img id="currentPhoto" src="products/<?php echo $readrow['FLD_PRODUCT_IMAGE']?>" onerror="this.onerror=null; this.src='default.jpg'" width=100% style="height: 400px;"> 
   
    </div>
    <div class="col-xs-12 col-sm-5 col-md-4">
      <div class="panel panel-default">
      <div class="panel-heading"><strong>Product Details</strong></div>
      <div class="panel-body">
          Below are specifications of the product.
      </div>
      <table class="table">
        <tr>
          <td class="col-xs-4 col-sm-4 col-md-4"><strong>Product ID</strong></td>
          <td><?php echo $readrow['FLD_PRODUCT_ID'] ?></td>
        </tr>
        <tr>
          <td><strong>Name</strong></td>
          <td><?php echo $readrow['FLD_PRODUCT_NAME'] ?></td>
        </tr>
        <tr>
          <td><strong>Price</strong></td>
          <td>$ <?php echo $readrow['FLD_PRODUCT_PRICE'] ?></td>
        </tr>
        <tr>
          <td><strong>Year</strong></td>
          <td><?php echo $readrow['FLD_PRODUCT_YEAR'] ?></td>
        </tr>
        <tr>
          <td><strong>Country</strong></td>
          <td><?php echo $readrow['FLD_PRODUCT_COUNTRY'] ?></td>
        </tr>
        <tr>
          <td><strong>Size</strong></td>
          <td><?php echo $readrow['FLD_PRODUCT_SIZE'] ?></td>
        </tr>
        <tr>
          <td><strong>Description</strong></td>
          <td><?php echo $readrow['FLD_PRODUCT_DESCRIPTION'] ?></td>
        </tr>
      </table>
      </div>
    </div>
  </div>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
 
</body>
</html>

<!-- <!DOCTYPE html>
<html>
<head>
  <title>Rare Coinage Shop : Products Details</title>
</head>
<body>
  <center>
    <a href="index.php">Home</a> |
    <a href="products.php">Products</a> |
    <a href="customers.php">Customers</a> |
    <a href="staffs.php">Staffs</a> |
    <a href="orders.php">Orders</a>
    
    <hr>
    <?php
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM tbl_products_a176252_pt2 WHERE FLD_PRODUCT_ID = :pid");
      $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
      $pid = $_GET['pid'];
      $stmt->execute();
      $readrow = $stmt->fetch(PDO::FETCH_ASSOC);
      }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    ?>
    <h1 style="font-size:large;">Product Details</h1>
    <table border="2" width="1150" style="font-size: medium;">
      <tr align="center">
        <td>Product ID</td>
        <td>Name</td>
        <td>Price($)</td>
        <td>Year</td>
        <td>Country</td>
        <td>Size</td>
        <td>Quantity</td>
      </tr>
      <tr align="center">
        <td><?php echo $readrow['FLD_PRODUCT_ID'] ?></td>
        <td><?php echo $readrow['FLD_PRODUCT_NAME'] ?></td>
        <td><?php echo $readrow['FLD_PRODUCT_PRICE'] ?></td>
        <td><?php echo $readrow['FLD_PRODUCT_YEAR'] ?></td>
        <td><?php echo $readrow['FLD_PRODUCT_COUNTRY'] ?></td>
        <td><?php echo $readrow['FLD_PRODUCT_SIZE'] ?></td>
        <td><?php echo $readrow['FLD_PRODUCT_QUANTITY'] ?></td>
    </table>
    <p align="justify">Description:<br> <?php echo $readrow['FLD_PRODUCT_DESCRIPTION']?></p>
    <br>
    <img src="products/<?php echo $readrow['FLD_PRODUCT_ID'] ?>.jpg" width="50%" height="50%">
    </center>
</body>
</html> -->