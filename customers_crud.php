<?php
 
include 'database.php';
 
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
//Create
if (isset($_POST['create'])) {
 
  try {
    $stmt2 = $conn->query("SELECT max(FLD_CUSTOMER_ID) AS CusID FROM tbl_customers_a176252_pt2");

    $max_row = $stmt2->fetch(PDO::FETCH_ASSOC);
    $max = "C101";
    if(isset($max_row['CusID'])){ 
      $max = $max_row['CusID'];
      $max++;
    }

    $stmt2->execute();

    $stmt = $conn->prepare("INSERT INTO tbl_customers_a176252_pt2(FLD_CUSTOMER_ID, FLD_CUSTOMER_NAME,
      FLD_CUSTOMER_IC, FLD_CUSTOMER_GENDER, FLD_CUSTOMER_CONTACTNUM, FLD_CUSTOMER_ADDRESS) VALUES(:cid, :name, :IC,
      :gender, :phone, :address)");
   
    $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':IC', $IC, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
       
    $cid = $max;
    $name = $_POST['name'];
    $IC = $_POST['IC'];
    $gender =  $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
       
    $stmt->execute();
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Update
if (isset($_POST['update'])) {
   
  try {
 
    $stmt = $conn->prepare("UPDATE tbl_customers_a176252_pt2 SET FLD_CUSTOMER_ID = :cid,
      FLD_CUSTOMER_NAME = :name, FLD_CUSTOMER_IC = :IC,
      FLD_CUSTOMER_GENDER = :gender, FLD_CUSTOMER_CONTACTNUM = :phone,
      FLD_CUSTOMER_ADDRESS = :address
      WHERE FLD_CUSTOMER_ID = :oldcid");
   
    $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':IC', $IC, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':oldcid', $oldcid, PDO::PARAM_STR);
       
    $cid = $_POST['cid'];
    $name = $_POST['name'];
    $IC = $_POST['IC'];
    $gender =  $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $oldcid = $_POST['oldcid'];
       
    $stmt->execute();
 
    header("Location: customers.php");
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Delete
if (isset($_GET['delete'])) {
 
  try {
 
    $stmt = $conn->prepare("DELETE FROM tbl_customers_a176252_pt2 WHERE FLD_CUSTOMER_ID = :cid");
   
    $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
       
    $cid = $_GET['delete'];
     
    $stmt->execute();
 
    header("Location: customers.php");
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Edit
if (isset($_GET['edit'])) {
   
  try {
 
    $stmt = $conn->prepare("SELECT * FROM tbl_customers_a176252_pt2 WHERE FLD_CUSTOMER_ID = :cid");
   
    $stmt->bindParam(':cid', $cid, PDO::PARAM_STR);
       
    $cid = $_GET['edit'];
     
    $stmt->execute();
 
    $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
  $conn = null;
 
?>