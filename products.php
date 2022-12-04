<?php
  include_once 'products_crud.php';
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

  
  <?php include_once 'nav_bar.php'; ?>
 
<div class="container-fluid">
<?php
  if($_SESSION['user']['FLD_STAFF_USERLEVEL'] == "admin"){?>  
    <div class="row">
      <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
        <div class="page-header">
          <h2>Create New Product</h2>
        </div>
      <form action="products.php" method="post" class="form-horizontal" enctype="multipart/form-data">
        <div class="form-group">
            <label for="productid" class="col-sm-3 control-label">ID</label>
            <div class="col-sm-9">
            <input name="pid" type="text" class="form-control" id="productid" placeholder="Auto-generated" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRODUCT_ID']; ?>" readonly>
          </div>
          </div>
        <div class="form-group">
            <label for="productname" class="col-sm-3 control-label">Name</label>
            <div class="col-sm-9">
            <input name="name" type="text" class="form-control" id="productname" placeholder="e.g. Silver Coin" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRODUCT_NAME']; ?>" required>
          </div>
        </div>
        <div class="form-group">
            <label for="productprice" class="col-sm-3 control-label">Price($)</label>
            <div class="col-sm-9">
            <input name="price" type="number" class="form-control" id="productprice" placeholder="e.g. 1000" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRODUCT_PRICE']; ?>" min="1" step="0.01" required>
          </div>
        </div>
        <div class="form-group">
            <label for="productyear" class="col-sm-3 control-label">Year</label>
            <div class="col-sm-9">
            <input name="year" type="text" class="form-control" id="productyear" placeholder="e.g. 1923" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRODUCT_YEAR']; ?>" required>
          </div>
        </div>
        <div class="form-group">
            <label for="productcountry" class="col-sm-3 control-label">Country</label>
            <div class="col-sm-9">
            <input name="country" type="text" class="form-control" id="productcountry" placeholder="e.g. Greek" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRODUCT_COUNTRY']; ?>" required>
          </div>
        </div>

        <div class="form-group">
            <label for="productsize" class="col-sm-3 control-label">Size</label>
            <div class="col-sm-9">
            <select name="size" class="form-control" id="productsize" required>
              <option value="">Please select</option>
              <option value="B" <?php if(isset($_GET['edit'])) if($editrow['FLD_PRODUCT_SIZE']=="B") echo "selected"; ?>>Big</option>
              <option value="M" <?php if(isset($_GET['edit'])) if($editrow['FLD_PRODUCT_SIZE']=="M") echo "selected"; ?>>Medium</option>
              <option value="S" <?php if(isset($_GET['edit'])) if($editrow['FLD_PRODUCT_SIZE']=="S") echo "selected"; ?>>Small</option>
            </select>
          </div>
        </div> 

         <div class="form-group">
            <label for="productquantity" class="col-sm-3 control-label">Quantity</label>
            <div class="col-sm-9">
            <input name="quantity" type="number" class="form-control" id="productquantity" placeholder="e.g. 1" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_PRODUCT_QUANTITY']; ?>" min="1" step="1" required>
          </div>
        </div>
        <div class="form-group">
            <label for="productdescription" class="col-sm-3 control-label">Description</label>
            <div class="col-sm-9">
              <textarea name="description" type="text" placeholder="e.g. Silver coin is a symbol of freedom of Greek" rows="10" cols="55" style="text-align: justify;"><?php if(isset($_GET['edit'])) echo $editrow['FLD_PRODUCT_DESCRIPTION'];?></textarea>
          </div>
        </div>
        <?php if (isset($_GET['edit'])) { ?>
          <div class="form-group">
            <label for="currentPhoto" class="col-sm-3 control-label">Current Image</label>
            <div class="col-sm-9">
              <img id="currentPhoto" src="products/<?php echo $editrow['FLD_PRODUCT_IMAGE'];?>" onerror="this.onerror=null; this.src='default.jpg'" width=25% style="height: 125px;"> 
            </div>
          </div>
        <?php } ?>

        <div class="form-group">
            <label for="productImage" class="col-sm-3 control-label"><?php if (isset($_GET['edit'])) echo "New "?>Image</label>
            <div class="col-sm-9">
            <input type='file' name='image' id='productImage'>
         </div>
        </div>  
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
            <?php if (isset($_GET['edit'])) { ?>
            <input type="hidden" name="oldpid" value="<?php echo $editrow['FLD_PRODUCT_ID']; ?>">
            <button class="btn btn-default" type="submit" name="update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update</button>
            <button class="btn btn-default" type="button" onclick="window.location.href = 'products.php';"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back</button>
            <?php } else { ?>
            <button class="btn btn-default" type="submit" name="create"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create</button>
            <button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Clear</button>
            <?php } ?>
            
          </div>
        </div>
      </form>
      </div>
    </div>
  <?php } ?>
 
  <div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <div class="page-header">
        <h2>Products List</h2>
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
      $per_page = 5;
      if (isset($_GET["page"]))
        $page = $_GET["page"];
      else
        $page = 1;
      $start_from = ($page-1) * $per_page;
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("select * from tbl_products_a176252_pt2 LIMIT $start_from, $per_page");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
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
          <?php 
          if($_SESSION['user']['FLD_STAFF_USERLEVEL'] == "admin"){?>
            <a href="products.php?edit=<?php echo $readrow['FLD_PRODUCT_ID']; ?>" class="btn btn-success btn-xs" role="button"> Edit </a>
            <a href="products.php?delete=<?php echo $readrow['FLD_PRODUCT_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
          <?php }?>
        </td>
      </tr>
      <?php } ?>
      </table>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <nav>
          <ul class="pagination">
          <?php
          try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM tbl_products_a176252_pt2");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $total_records = count($result);
          }
          catch(PDOException $e){
                echo "Error: " . $e->getMessage();
          }
          $total_pages = ceil($total_records / $per_page);
          ?>
          <?php if ($page==1) { ?>
            <li class="disabled"><span aria-hidden="true">«</span></li>
          <?php } else { ?>
            <li><a href="products.php?page=<?php echo $page-1 ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
          <?php
          }
          for ($i=1; $i<=$total_pages; $i++)
            if ($i == $page)
              echo "<li class=\"active\"><a href=\"products.php?page=$i\">$i</a></li>";
            else
              echo "<li><a href=\"products.php?page=$i\">$i</a></li>";
          ?>
          <?php if ($page==$total_pages) { ?>
            <li class="disabled"><span aria-hidden="true">»</span></li>
          <?php } else { ?>
            <li><a href="products.php?page=<?php echo $page+1 ?>" aria-label="Previous"><span aria-hidden="true">»</span></a></li>
          <?php } ?>
        </ul>
      </nav>
    </div>
  </div>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
 
</body>
</html>