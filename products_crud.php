<?php
 
include 'database.php';
 
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
//Create
if (isset($_POST['create'])) {
 
  try {
      $stmt2 = $conn->query("SELECT max(FLD_PRODUCT_ID) AS ProductID FROM tbl_products_a176252_pt2");

      $max_row = $stmt2->fetch(PDO::FETCH_ASSOC);
      $max = "MA10001";
      if(isset($max_row['ProductID'])){ 
        $max = $max_row['ProductID'];
        $max++;
      }

      $stmt2->execute();

      $target_dir = "products/";
      $target_file = $target_dir.basename($_FILES["image"]["name"]);
      $uploadOk = 1;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
     
      // Check if image file is a actual image or fake image
      if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
          $uploadOk = 1;
        } else {
          echo "File is not an image. ";
          $uploadOk = 0;
        }
      }

      // Allow certain file formats
      if($imageFileType != "gif" ) {
        echo "Sorry, only GIF files are allowed. ";
        $uploadOk = 0;
      }
      else if ($_FILES["image"]["size"] > 10000000) { // Check file size
        echo "Sorry, your file is too large. ";
        $uploadOk = 0;
      }
      else if (file_exists($target_file)) {
        unlink($target_file); // remove existed file
      }

      if ($uploadOk != 0) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir.$max.".gif")) {
          $stmt = $conn->prepare("INSERT INTO tbl_products_a176252_pt2(FLD_PRODUCT_ID,
            FLD_PRODUCT_NAME, FLD_PRODUCT_PRICE, FLD_PRODUCT_YEAR, FLD_PRODUCT_COUNTRY, FLD_PRODUCT_SIZE,
            FLD_PRODUCT_QUANTITY, FLD_PRODUCT_DESCRIPTION, FLD_PRODUCT_IMAGE) VALUES(:pid, :name, :price, :year,
            :country, :size, :quantity, :description, :image)");
         
          $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
          $stmt->bindParam(':name', $name, PDO::PARAM_STR);
          $stmt->bindParam(':price', $price, PDO::PARAM_INT);
          $stmt->bindParam(':year', $year, PDO::PARAM_STR);
          $stmt->bindParam(':country', $country, PDO::PARAM_STR);
          $stmt->bindParam(':size', $size, PDO::PARAM_STR);
          $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
          $stmt->bindParam(':description', $description, PDO::PARAM_STR);
          $stmt->bindParam(':image', $image, PDO::PARAM_STR);
           
          $pid = $max;
          $name = $_POST['name'];
          $price = $_POST['price'];
          $year =  $_POST['year'];
          $country = $_POST['country'];
          $size =  $_POST['size'];
          $quantity = $_POST['quantity'];
          $description = $_POST['description'];
          $image = $pid.'.gif';
          
          $stmt->execute();
          echo "The image is successfully uploaded and its file name is inserted in the table!";
        }
        else{
          echo "Sorry, there was an error uploading your file.";
        }
      }
      else{
        echo "Sorry, your file was not uploaded.";
      }
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Update
if (isset($_POST['update'])) {
 
  try {
      if($_FILES['image']['size'] > 0){
        $uploadOk = 1;
        $target_dir = "products/";
        $target_file = $target_dir.basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
       
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
          $check = getimagesize($_FILES["image"]["tmp_name"]);
          if($check !== false) {
            $uploadOk = 1;
          } else {
            echo "File is not an image. ";
            $uploadOk = 0;
          }
        }

        // Allow certain file formats
        if($imageFileType != "gif" ) {
          echo "Sorry, only GIF files with 10 MB are allowed. ";
          $uploadOk = 0;
        }
        else if ($_FILES["image"]["size"] > 10000000) { // Check file size
          echo "Sorry, your file is too large. ";
          $uploadOk = 0;
        }
        else if (file_exists($target_file)) {
          unlink($target_file); // remove existed file
        }
        if($uploadOk != 0){
          if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir.$_POST['pid'].".gif")) {
            echo "The new image file is successfully overwrite the existing image file and its new file name is updated in the table";
          }
          else
            echo "Sorry, there was an error uploading your file.";
        }
          else
            echo "So, your file was not uploaded.";
      }

      $stmt = $conn->prepare("UPDATE tbl_products_a176252_pt2 SET FLD_PRODUCT_ID = :pid,
        FLD_PRODUCT_NAME = :name, FLD_PRODUCT_PRICE = :price, FLD_PRODUCT_YEAR = :year,
        FLD_PRODUCT_COUNTRY = :country, FLD_PRODUCT_SIZE= :size, FLD_PRODUCT_QUANTITY = :quantity,
        FLD_PRODUCT_DESCRIPTION = :description WHERE FLD_PRODUCT_ID = :oldpid");
     
      $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->bindParam(':price', $price, PDO::PARAM_INT);
      $stmt->bindParam(':year', $year, PDO::PARAM_STR);
      $stmt->bindParam(':country', $country, PDO::PARAM_STR);
      $stmt->bindParam(':size', $size, PDO::PARAM_STR);
      $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
      $stmt->bindParam(':description', $description, PDO::PARAM_STR);
      $stmt->bindParam(':oldpid', $oldpid, PDO::PARAM_STR);
       
      $pid = $_POST['pid'];
      $name = $_POST['name'];
      $price = $_POST['price'];
      $year =  $_POST['year'];
      $country = $_POST['country'];
      $size = $_POST['size'];
      $quantity = $_POST['quantity'];
      $description = $_POST['description'];
      $oldpid = $_POST['oldpid'];
       
      $stmt->execute();
 

    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Delete
if (isset($_GET['delete'])) {
 
  try {
 
      $stmt = $conn->prepare("DELETE FROM tbl_products_a176252_pt2 WHERE FLD_PRODUCT_ID = :pid");
     
      $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
       
     
    $pid = $_GET['delete'];

     
    $stmt->execute();
 
    header("Location: products.php");
    }
 
  catch(PDOException $e)
  {
      echo "Error: " . $e->getMessage();
  }
}
 
//Edit
if (isset($_GET['edit'])) {
 
  try {
 
      $stmt = $conn->prepare("SELECT * FROM tbl_products_a176252_pt2 WHERE FLD_PRODUCT_ID = :pid");
     
      $stmt->bindParam(':pid', $pid, PDO::PARAM_STR);
       
    $pid = $_GET['edit'];
     
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