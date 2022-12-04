<?php
  include 'customers_crud.php';
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
  <title>Rare Coinage Shop : Customers</title>
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
        <h2>Create New Customer</h2>
      </div>
    <form action="customers.php" method="post" class="form-horizontal">
      <div class="form-group">
          <label for="customerid" class="col-sm-3 control-label">ID</label>
          <div class="col-sm-9">
          <input name="cid" type="text" class="form-control" id="customerid" placeholder="Auto-generated" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_ID']; ?>" readonly>
        </div>
        </div>
      <div class="form-group">
          <label for="customername" class="col-sm-3 control-label">Name</label>
          <div class="col-sm-9">
          <input name="name" type="text" class="form-control" id="customername" placeholder="e.g. Siti Aisyah" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_NAME']; ?>" required>
        </div>
      </div>
      <div class="form-group">
          <label for="customerIC" class="col-sm-3 control-label">IC</label>
          <div class="col-sm-9">
          <input name="IC" type="text" class="form-control" id="customerIC" placeholder="e.g. 990101012345" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_IC'];?>" pattern="(([[1-9]{2})(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01]))([0-9]{2})([0-9]{4})" required>
        </div>
      </div>
      <div class="form-group">
          <label for="customergender" class="col-sm-3 control-label">Gender</label>
          <div class="col-sm-9">
          <div class="radio">
              <label>
              <input name="gender" type="radio" id="customergender" value="M" <?php if(isset($_GET['edit'])) if($editrow['FLD_CUSTOMER_GENDER']=="M") echo "checked"; ?> required> Male
            </label>
          </div>
          <div class="radio">
              <label>
                <input name="gender" type="radio" id="customergender" value="F" <?php if(isset($_GET['edit'])) if($editrow['FLD_CUSTOMER_GENDER']=="F") echo "checked"; ?> > Female
            </label>
            </div>
          </div>
      </div>
       <div class="form-group">
          <label for="customerphone" class="col-sm-3 control-label">Phone Number</label>
          <div class="col-sm-9">
          <input name="phone" type="text" class="form-control" id="customerphone" pattern="^(\+?6?01)[0|1|2|3|4|6|7|8|9]*[0-9]{7,8}$" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_CONTACTNUM']; ?>" placeholder="e.g. 60#########" required>
        </div>
      </div>
       <div class="form-group">
          <label for="customeraddress" class="col-sm-3 control-label">Address</label>
          <div class="col-sm-9">
          <input name="address" type="text" class="form-control" id="customeraddress" placeholder="e.g. No.72, Jalan Bunga, Taman Intan, 81900 Kota Tinggi, Johor" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_CUSTOMER_ADDRESS']; ?>" required>
        </div>
      </div>
      <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
          <?php if (isset($_GET['edit'])) { ?>
          <input type="hidden" name="oldcid" value="<?php echo $editrow['FLD_CUSTOMER_ID']; ?>">
          <button class="btn btn-default" type="submit" name="update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update</button>
           <button class="btn btn-default" type="button" onclick="window.location.href = 'customers.php';"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back</button>
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
        <h2>Customers List</h2>
      </div>
      <table class="table table-striped table-bordered">
        <tr>
          <td>Customer ID</td>
          <td>Name</td>
          <td>IC</td>
          <td>Gender</td>
          <td>Phone Number</td>
          <td>Address</td>
          <?php 
          if($_SESSION['user']['FLD_STAFF_USERLEVEL'] == "admin"){?>
          <td>View</td>
          <?php }?>
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
        $stmt = $conn->prepare("select * from tbl_customers_a176252_pt2 LIMIT $start_from, $per_page");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
      ?> 
      <tr>
        <td><?php echo $readrow['FLD_CUSTOMER_ID']; ?></td>
        <td><?php echo $readrow['FLD_CUSTOMER_NAME']; ?></td>
        <td><?php echo $readrow['FLD_CUSTOMER_IC']; ?></td>
        <td><?php echo $readrow['FLD_CUSTOMER_GENDER']; ?></td>
        <td><?php echo $readrow['FLD_CUSTOMER_CONTACTNUM']; ?></td>
        <td><?php echo $readrow['FLD_CUSTOMER_ADDRESS']; ?></td>
        <?php 
          if($_SESSION['user']['FLD_STAFF_USERLEVEL'] == "admin"){?>
        <td>
          <a href="customers.php?edit=<?php echo $readrow['FLD_CUSTOMER_ID']; ?>" class="btn btn-success btn-xs" role="button"> Edit </a>
          <a href="customers.php?delete=<?php echo $readrow['FLD_CUSTOMER_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
        </td>
        <?php } ?>
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
            $stmt = $conn->prepare("SELECT * FROM tbl_customers_a176252_pt2");
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
            <li><a href="customers.php?page=<?php echo $page-1 ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
          <?php
          }
          for ($i=1; $i<=$total_pages; $i++)
            if ($i == $page)
              echo "<li class=\"active\"><a href=\"customers.php?page=$i\">$i</a></li>";
            else
              echo "<li><a href=\"customers.php?page=$i\">$i</a></li>";
          ?>
          <?php if ($page==$total_pages) { ?>
            <li class="disabled"><span aria-hidden="true">»</span></li>
          <?php } else { ?>
            <li><a href="customers.php?page=<?php echo $page+1 ?>" aria-label="Previous"><span aria-hidden="true">»</span></a></li>
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