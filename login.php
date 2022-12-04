<?php
  include_once 'login_crud.php';
?>

<!DOCTYPE html>    
<html>    
<head>    
    <title>Rare Coinage Shop : Login</title>    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <link href="css/login.css" rel="stylesheet">
</head>    
<body>    
<div class="container" id="container">
    <div class="form-container login-in-container">
        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
            <img id="currentPhoto" src="resources/logo.jpg" onerror="this.onerror=null; this.src='default.jpg'" style="height: 150px;"> 
            <h1>Rare Coinage Shop</h1>
            <h2>Login Page</h2>
            <input type="email" name="username" placeholder="Email" />
            <input type="password" name="password" placeholder="Password" />
            <?php
                if (isset($_SESSION['error'])) {
                    echo "<script type=\"text/javascript\">Swal.fire({title:\"Alert Box\",html:\"".$_SESSION['error']."\",confirmButtonText: \"Got it\",});</script>";
                    unset($_SESSION['error']);
                }
            ?>   
            <input type="submit" name="log" id="log" value="Login">  
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <h3>Hello, Visitors!</h3>
                <p>Refer hint to login this system!</p>
                <button class="ghost" id="hint" onclick="return hint();">Hint</button>
            </div>
        </div>
    </div>
</div>   
<script type="text/javascript">

    function hint(){
        Swal.fire({
          title: "<strong>Hint</strong>", 
          html: "<h1>Example Admin</h1><hr>aliabu@gmail.com<br>aliabu123<br><h1>Example User</h1><hr>weisheng21@gmail.com<br>maxthebest99<br>",
          confirmButtonText: "Got it", 
        });
    }

    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
</script>   
</body>
</html> 