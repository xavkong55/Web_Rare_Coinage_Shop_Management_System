<?php
  include 'orders_crud.php';
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
  <title>Rare Coinage Shop : Orders</title>
  <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include_once 'nav_bar.php'; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
      <div class="page-header">
        <h2>Create New Order</h2>
      </div>
     
      <form action="orders.php" method="post" class="form-horizontal">
      <div class="form-group">
          <label for="orderId" class="col-sm-3 control-label">ID</label>
          <div class="col-sm-9">
            <input name="oid" type="text" class="form-control" id="orderId" readonly placeholder="Auto-generated" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_ORDER_ID']; ?>" required>
        </div>
      </div>

      <div class="form-group">
          <label for="orderDate" class="col-sm-3 control-label">Date</label>
          <div class="col-sm-9">
            <input name="orderdate" type="text" class="form-control" readonly id="orderDate" placeholder="Auto-generated" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_ORDER_DATE']; ?>" required>
        </div>
      </div>

      <div class="form-group">
          <label for="staffId" class="col-sm-3 control-label">Staff Name</label>
          <div class="col-sm-9">
          <select name="sid" class="form-control" id="staffId" required>
            <option value="">Please select</option>
            <?php
            try {
              $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
              $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a176252_pt2");
              $stmt->execute();
              $result = $stmt->fetchAll();
            }
            catch(PDOException $e){
                  echo "Error: " . $e->getMessage();
            }
            foreach($result as $staffrow) {
            ?>
              <?php if((isset($_GET['edit'])) && ($editrow['FLD_STAFF_ID']==$staffrow['FLD_STAFF_ID'])) { ?>
                <option value="<?php echo $staffrow['FLD_STAFF_ID']; ?>" selected><?php echo $staffrow['FLD_STAFF_NAME'];?></option>
              <?php } else { ?>
                <option value="<?php echo $staffrow['FLD_STAFF_ID']; ?>"><?php echo $staffrow['FLD_STAFF_NAME'];?></option>
              <?php } ?>
            <?php
            } // while
            $conn = null;
            ?> 
          </select>
        </div>
        </div>

      <div class="form-group">
        <label for="customerId" class="col-sm-3 control-label">Customer Name</label>
        <div class="col-sm-9">
        <select name="cid" class="form-control" id="customerId" required>
          <option value="">Please select</option>
          <?php
          try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM tbl_customers_a176252_pt2");
            $stmt->execute();
            $result = $stmt->fetchAll();
          }
          catch(PDOException $e){
                echo "Error: " . $e->getMessage();
          }
          foreach($result as $cusrow) {
          ?>
            <?php if((isset($_GET['edit'])) && ($editrow['FLD_CUSTOMER_ID']==$cusrow['FLD_CUSTOMER_ID'])) { ?>
              <option value="<?php echo $cusrow['FLD_CUSTOMER_ID']; ?>" selected><?php echo $cusrow['FLD_CUSTOMER_NAME'];?></option>
            <?php } else { ?>
              <option value="<?php echo $cusrow['FLD_CUSTOMER_ID']; ?>"><?php echo $cusrow['FLD_CUSTOMER_NAME'];?></option>
            <?php } ?>
          <?php
          } // while
          $conn = null;
          ?> 
        </select>
      </div>
      </div>  

      <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
          <?php if (isset($_GET['edit'])) { ?>
          <input type="hidden" name="oldcid" value="<?php echo $editrow['FLD_ORDER_ID']; ?>">
          <button class="btn btn-default" type="submit" name="update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update</button>
           <button class="btn btn-default" type="button" onclick="window.location.href = 'orders.php';"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back</button>
          <?php } else { ?>
          <button class="btn btn-default" type="submit" name="create"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create</button>
          <button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span> Clear</button>
          <?php } ?>
        </div>
      </div>
      </form>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <div class="page-header">
        <h2>Orders List</h2>
      </div>
      <table class="table table-striped table-bordered">
      <tr>
        <td>Order ID</td>
        <td>Order Date</td>
        <td>Staff ID</td>
        <td>Customer ID</td>
        <td>View</td>
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
        $stmt = $conn->prepare("select * from tbl_orders_a176252_pt2 LIMIT $start_from, $per_page");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
      ?> 

      <tr>
        <td><?php echo $readrow['FLD_ORDER_ID']; ?></td>
        <td><?php echo $readrow['FLD_ORDER_DATE']; ?></td>
        <td><?php echo $readrow['FLD_STAFF_ID']; ?></td>
        <td><?php echo $readrow['FLD_CUSTOMER_ID']; ?></td>
        <td>
          <a href="orders_details.php?oid=<?php echo $readrow['FLD_ORDER_ID']; ?>" class="btn btn-warning btn-xs" role="button">Details</a>
          <?php
          if($_SESSION['user']['FLD_STAFF_USERLEVEL'] == "admin"){?> 
          <a href="orders.php?edit=<?php echo $readrow['FLD_ORDER_ID']; ?>" class="btn btn-success btn-xs" role="button"> Edit </a>
          <a href="orders.php?delete=<?php echo $readrow['FLD_ORDER_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
          <?php } ?>
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
            $stmt = $conn->prepare("SELECT * FROM tbl_orders_a176252_pt2");
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
            <li><a href="orders.php?page=<?php echo $page-1 ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
          <?php
          }
          for ($i=1; $i<=$total_pages; $i++)
            if ($i == $page)
              echo "<li class=\"active\"><a href=\"orders.php?page=$i\">$i</a></li>";
            else
              echo "<li><a href=\"orders.php?page=$i\">$i</a></li>";
          ?>
          <?php if ($page==$total_pages) { ?>
            <li class="disabled"><span aria-hidden="true">»</span></li>
          <?php } else { ?>
            <li><a href="orders.php?page=<?php echo $page+1 ?>" aria-label="Previous"><span aria-hidden="true">»</span></a></li>
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