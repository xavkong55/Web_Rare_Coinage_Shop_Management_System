<!DOCTYPE html>
<html>
<head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Rare Coinage Shop : Products</title>
  <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
 
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<?php

include 'database.php';

if (!isset($_SESSION['loggedin']))
  header("Location: logout.php");
;
$val = array();
if (isset($_GET['search'])) {
	try {
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$search = $_GET['search'];
			$val = explode(" ", $search); //split by space
			$queries = array(); //query array

			foreach($val as $value){
				$queries[] = "SELECT * FROM `tbl_products_a176252_pt2` WHERE FLD_PRODUCT_NAME LIKE '%{$value}%' OR FLD_PRODUCT_PRICE LIKE '%{$value}%' OR FLD_PRODUCT_YEAR LIKE '%{$value}%'"; //get each related data
			}
			$sql = implode(' UNION ',$queries); //combine all data
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();
		}
		
		catch(PDOException $e){
		  	echo "Error: " . $e->getMessage();
		}
}


$conn = null;
?>

<?php include_once 'nav_bar.php'; 
if(!empty($result)){?>
	<div class="row">
	    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
	      <div class="page-header">
	       <h2>Products Searching List (Filter by Name Price Year)</h2> <!-- print product table -->
	      </div>
	      <table class="table table-striped table-bordered">
	        <tr>
	          <th>Product ID</th>
	          <th>Name</th>
	          <th>Price($)</th>
	          <th>Year</th>
	          <th>Country</th>
	          <th>Size</th>
	          <th>Quantity</th>
	          <th>Description</th>
	          <th>View</th>
	        </tr>
	      <?php
	      // Read
	      foreach($result as $readrow) {
	      ?> 
	      <tr>
	        <td><?php echo $readrow['FLD_PRODUCT_ID']; ?></td>
	        <td><?php echo $readrow['FLD_PRODUCT_NAME']; ?></td>
	        <td><?php echo $readrow['FLD_PRODUCT_PRICE']; ?></td>
	        <td><?php echo $readrow['FLD_PRODUCT_YEAR']; ?></td>
	        <td><?php echo $readrow['FLD_PRODUCT_COUNTRY']; ?></td>
	        <td><?php echo $readrow['FLD_PRODUCT_SIZE']; ?></td>
	        <td><?php echo $readrow['FLD_PRODUCT_QUANTITY']; ?></td>
	        <td><?php echo $readrow['FLD_PRODUCT_DESCRIPTION']; ?></td>
	        <td>
	          <a href="products_details.php?pid=<?php echo $readrow['FLD_PRODUCT_ID']; ?>" class="btn btn-warning btn-xs" role="button">Details</a>
	        </td>
	      </tr>
	      <?php } ?>
	      </table>
	    </div>
	  </div>
	<?php }
	else{ //if no result ?> 
		<script>Swal.fire({ 
          title: "<strong>Searching Result</strong>", 
          html: "<h1>Sorry, <br>Not Found!</h1>",
          confirmButtonText: "Return to Homepage", 
        }).then((result) => {
		  /* Read more about isConfirmed, isDenied below */
		  if (result.isConfirmed) {
		    window.location.href = "index.php";
		}});
    </script>
	<?php } ?>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
 
</body>
</html>