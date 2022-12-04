<?php
 
include_once 'database.php';
 
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
//Create
if (isset($_POST['addproduct'])) {
 
  try {

    $stmt2 = $conn->query("SELECT max(FLD_ORDER_DETAIL_ID) AS OrderDetailsID FROM tbl_orders_details_a176252_pt2");
    $max_row = $stmt2->fetch(PDO::FETCH_ASSOC);
    $max = "OR100001";
    if(isset($max_row['OrderDetailsID'])){ 
      $max = $max_row['OrderDetailsID'];
      $max++;
    }

    $stmt2->execute();

    $stmt = $conn->prepare("INSERT INTO tbl_orders_details_a176252_pt2(FLD_ORDER_DETAIL_ID,
      FLD_ORDER_ID, FLD_PRODUCT_ID, FLD_ORDER_DETAIL_QUANTITY) VALUES(:did, :oid,
      :pid, :quantity)");
   
    $stmt->bindParam(':did', $did, PDO::PARAM_STR);
    $stmt->bindParam(':oid', $oid, PDO::PARAM_STR);
    $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
       
    $did = $max;
    $oid = $_POST['oid'];
    $pid = $_POST['pid'];
    $quantity= $_POST['quantity'];
     
    $stmt->execute();
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
  $_GET['oid'] = $oid;
}
 
//Delete
if (isset($_GET['delete'])) {
 
  try {
 
    $stmt = $conn->prepare("DELETE FROM tbl_orders_details_a176252_pt2 where FLD_ORDER_DETAIL_ID = :did");
   
    $stmt->bindParam(':did', $did, PDO::PARAM_STR);
       
    $did = $_GET['delete'];
     
    $stmt->execute();
 
    header("Location: orders_details.php?oid=".$_GET['oid']);
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
?>