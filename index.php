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
  <title>Rare Coinage Shop: Home</title>
  <link href="css/index.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
   <!--  <link href="css/index.css" rel="stylesheet"> -->
</head>
<body>
<?php include_once 'nav_bar.php'; ?>
 <div class="logo-class"></div>
  <div id="cover">
      <form method="get" action="search.php" >
        <div class="tb">
          <div class="td">
            <input type="text" name="search" id="search" placeholder="e.g. Silver Dollar 1092500 1921" required>
          </div>
          <div class="td" id="s-cover">
            <button type="submit" name="submit">
              <div id="s-circle"></div>
              <span></span>
            </button>
          </div>
        </div>
      </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">  
</script>
</body>
</html>