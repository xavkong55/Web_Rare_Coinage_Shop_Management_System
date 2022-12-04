<?php
  include 'staffs_crud.php';
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
  <title>Rare Coinage Shop : Staffs</title>
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
        <h2>Create New Staff</h2>
      </div>
    <form action="staffs.php" method="post" class="form-horizontal">
      <div class="form-group">
          <label for="staffid" class="col-sm-3 control-label">ID</label>
          <div class="col-sm-9">
          <input name="sid" type="text" class="form-control" id="staffid" placeholder="Auto-generated" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_STAFF_ID']; ?>" readonly>
        </div>
        </div>
      <div class="form-group">
          <label for="staffname" class="col-sm-3 control-label">Name</label>
          <div class="col-sm-9">
          <input name="name" type="text" class="form-control" id="staffname" placeholder="e.g. Siti Aisyah" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_STAFF_NAME']; ?>" required>
        </div>
      </div>
      <div class="form-group">
          <label for="customergender" class="col-sm-3 control-label">Gender</label>
          <div class="col-sm-9">
          <div class="radio">
              <label>
              <input name="gender" type="radio" id="customergender" value="M" <?php if(isset($_GET['edit'])) if($editrow['FLD_STAFF_GENDER']=="M") echo "checked"; ?> required> Male
            </label>
          </div>
          <div class="radio">
              <label>
                <input name="gender" type="radio" id="customergender" value="F" <?php if(isset($_GET['edit'])) if($editrow['FLD_STAFF_GENDER']=="F") echo "checked"; ?> > Female
            </label>
            </div>
          </div>
      </div>

      <div class="form-group">
          <label for="staffposition" class="col-sm-3 control-label">Position</label>
          <div class="col-sm-9">
          <select name="position" class="form-control" id="staffposition" required>
            <option value="">Please select</option>
            <option value="Manager" <?php if(isset($_GET['edit'])) if($editrow['FLD_STAFF_POSITION']=="Manager") echo "selected"; ?>>Manager</option>
            <option value="Account" <?php if(isset($_GET['edit'])) if($editrow['FLD_STAFF_POSITION']=="Account") echo "selected"; ?>>Account</option>
            <option value="Salesman" <?php if(isset($_GET['edit'])) if($editrow['FLD_STAFF_POSITION']=="Salesman") echo "selected"; ?>>Salesman</option>
            <option value="Salesgirl" <?php if(isset($_GET['edit'])) if($editrow['FLD_STAFF_POSITION']=="Salesgirl") echo "selected"; ?>>Salesgirl</option>
          </select>
        </div>
      </div> 

      <div class="form-group">
          <label for="productsalary" class="col-sm-3 control-label">Salary(RM)</label>
          <div class="col-sm-9">
          <input name="salary" type="number" class="form-control" id="productsalary" placeholder="e.g. 2000" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_STAFF_SALARY']; ?>" min="0.0" step="0.01" required>
        </div>
      </div>
      <div class="form-group">
          <label for="staffphone" class="col-sm-3 control-label">Phone Number</label>
          <div class="col-sm-9">
          <input name="phone" type="text" class="form-control" id="staffphone" pattern="^(\+?6?01)[0|1|2|3|4|6|7|8|9]*[0-9]{7,8}$" placeholder="e.g. 60#########" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_STAFF_CONTACTNUM']; ?>" required>
        </div>
      </div>

      <div class="form-group">
          <label for="staffemail" class="col-sm-3 control-label">Email</label>
          <div class="col-sm-9">
          <input name="email" type="text" class="form-control" id="staffemail" placeholder="e.g. abc@gmail.com" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_STAFF_EMAIL']; ?>" required>
        </div>
      </div>

      <div class="form-group">
          <label for="stafflevel" class="col-sm-3 control-label">User Level</label>
          <div class="col-sm-9">
          <select name="level" class="form-control" id="stafflevel" required>
            <option value="">Please select</option>
            <option value="admin" <?php if(isset($_GET['edit'])) if($editrow['FLD_STAFF_USERLEVEL']=="admin") echo "selected"; ?>>Admin</option>
            <option value="user" <?php if(isset($_GET['edit'])) if($editrow['FLD_STAFF_USERLEVEL']=="user") echo "selected"; ?>>User</option>
          </select>
        </div>
      </div> 

      <div class="form-group">
          <label for="staffpassword" class="col-sm-3 control-label">Password</label>
          <div class="col-sm-9">
          <input name="password" type="text" class="form-control" id="staffpassword" placeholder="e.g. abc123" value="<?php if(isset($_GET['edit'])) echo $editrow['FLD_STAFF_PASSWORD']; ?>" required>
        </div>
      </div>

      <div class="form-group">
          <div class="col-sm-offset-3 col-sm-9">
          <?php if (isset($_GET['edit'])) { ?>
          <input type="hidden" name="oldsid" value="<?php echo $editrow['FLD_STAFF_ID']; ?>">
          <button class="btn btn-default" type="submit" name="update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Update</button>
           <button class="btn btn-default" type="button" onclick="window.location.href = 'staffs.php';"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Back</button>
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
        <h2>Staffs List</h2>
      </div>
      <table class="table table-striped table-bordered">
        <tr>
          <td>Staff ID</td>
          <td>Name</td>
          <td>Gender</td>
          <td>Position</td>
          <td>Salary(RM)</td>
          <td>Phone Number</td>
          <td>Email</td>
          <td>User Level</td>
          <?php
          if($_SESSION['user']['FLD_STAFF_USERLEVEL'] == "admin"){?> 
          <td>Password</td>
          <td>View</td>
          <?php } ?> 
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
        $stmt = $conn->prepare("select * from tbl_staffs_a176252_pt2 LIMIT $start_from, $per_page");
        $stmt->execute();
        $result = $stmt->fetchAll();
      }
      catch(PDOException $e){
            echo "Error: " . $e->getMessage();
      }
      foreach($result as $readrow) {
      ?> 
      <tr>
        <td><?php echo $readrow['FLD_STAFF_ID']; ?></td>
        <td><?php echo $readrow['FLD_STAFF_NAME']; ?></td>
        <td><?php echo $readrow['FLD_STAFF_GENDER']; ?></td>
        <td><?php echo $readrow['FLD_STAFF_POSITION']; ?></td>
        <td><?php echo $readrow['FLD_STAFF_SALARY']; ?></td>
        <td><?php echo $readrow['FLD_STAFF_CONTACTNUM']; ?></td>
        <td><?php echo $readrow['FLD_STAFF_EMAIL']; ?></td>
        <td><?php echo $readrow['FLD_STAFF_USERLEVEL']; ?></td>
        <?php
          if($_SESSION['user']['FLD_STAFF_USERLEVEL'] == "admin"){?> 
        <td><?php echo $readrow['FLD_STAFF_PASSWORD']; ?></td>
        <td>
          <a href="staffs.php?edit=<?php echo $readrow['FLD_STAFF_ID']; ?>" class="btn btn-success btn-xs" role="button"> Edit </a>
          <a href="staffs.php?delete=<?php echo $readrow['FLD_STAFF_ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
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
            $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a176252_pt2");
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
            <li><a href="staffs.php?page=<?php echo $page-1 ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
          <?php
          }
          for ($i=1; $i<=$total_pages; $i++)
            if ($i == $page)
              echo "<li class=\"active\"><a href=\"staffs.php?page=$i\">$i</a></li>";
            else
              echo "<li><a href=\"staffs.php?page=$i\">$i</a></li>";
          ?>
          <?php if ($page==$total_pages) { ?>
            <li class="disabled"><span aria-hidden="true">»</span></li>
          <?php } else { ?>
            <li><a href="staffs.php?page=<?php echo $page+1 ?>" aria-label="Previous"><span aria-hidden="true">»</span></a></li>
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