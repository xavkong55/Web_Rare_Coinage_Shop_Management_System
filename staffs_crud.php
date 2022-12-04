<?php
 
include 'database.php';
 
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
//Create
if (isset($_POST['create'])) {
 
  try {
    $stmt2 = $conn->query("SELECT max(FLD_STAFF_ID) AS StaffID FROM tbl_staffs_a176252_pt2");

    $max_row = $stmt2->fetch(PDO::FETCH_ASSOC);
    $max = "S101";
    if(isset($max_row['StaffID'])){ 
      $max = $max_row['StaffID'];
      $max++;
    }

    $stmt2->execute();

    $stmt = $conn->prepare("INSERT INTO tbl_staffs_a176252_pt2(FLD_STAFF_ID,FLD_STAFF_NAME,FLD_STAFF_GENDER,FLD_STAFF_POSITION, FLD_STAFF_SALARY, FLD_STAFF_CONTACTNUM,FLD_STAFF_EMAIL,FLD_STAFF_USERLEVEL,FLD_STAFF_PASSWORD) VALUES(:sid, :name, :gender, :position, :salary, :phone, :email, :level, :password)");
   
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':position', $position, PDO::PARAM_STR);
    $stmt->bindParam(':salary', $salary, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':level', $level, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
       
    $sid = $max;
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $position = $_POST['position'];
    $salary =  $_POST['salary'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $level = $_POST['level'];
    $password = $_POST['password'];
         
    $stmt->execute();
    header("Location: staffs.php");
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Update
if (isset($_POST['update'])) {
   
  try {
 
    $stmt = $conn->prepare("UPDATE tbl_staffs_a176252_pt2 SET
      FLD_STAFF_NAME = :name, FLD_STAFF_GENDER = :gender, 
      FLD_STAFF_POSITION = :position, FLD_STAFF_SALARY= :salary,
      FLD_STAFF_CONTACTNUM = :phone, FLD_STAFF_EMAIL = :email,
      FLD_STAFF_USERLEVEL = :level, FLD_STAFF_PASSWORD = :password
      WHERE FLD_STAFF_ID = :sid");
   
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':position', $position, PDO::PARAM_STR);
    $stmt->bindParam(':salary', $salary, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':level', $level, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
       
    $sid = $_POST['sid'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $position = $_POST['position'];
    $salary =  $_POST['salary'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $level = $_POST['level'];
    $password = $_POST['password'];
         
    $stmt->execute();
 
    header("Location: staffs.php");
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Delete
if (isset($_GET['delete'])) {
 
  try {
 
    $stmt = $conn->prepare("DELETE FROM tbl_staffs_a176252_pt2 where FLD_STAFF_ID = :sid");
   
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
       
    $sid = $_GET['delete'];
     
    $stmt->execute();
 
    header("Location: staffs.php");
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Edit
if (isset($_GET['edit'])) {
   
  try {
 
    $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a176252_pt2 where FLD_STAFF_ID = :sid");
   
    $stmt->bindParam(':sid', $sid, PDO::PARAM_STR);
       
    $sid = $_GET['edit'];
     
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