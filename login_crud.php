<?php
	require_once 'database.php';

	if (isset($_SESSION['loggedin'])){
    	header("LOCATION: index.php");
    }

    if (isset($_POST['username'], $_POST['password'])) {
    $UserID = htmlspecialchars($_POST['username']);
    $Pass = $_POST['password'];

    if (empty($UserID) || empty($Pass)) {
        $_SESSION['error'] = 'Please fill in the blanks.';
    } else {
    	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a176252_pt2 WHERE (FLD_STAFF_ID = :id OR FLD_STAFF_EMAIL = :id) LIMIT 1");
        $stmt->bindParam(':id', $UserID);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($user['FLD_STAFF_ID'])) {
            if ($user['FLD_STAFF_PASSWORD'] == $Pass) {
                unset($user['FLD_STAFF_PASSWORD']);
                $_SESSION['loggedin'] = true;
                $_SESSION['user'] = $user;
                header("LOCATION: index.php");
                exit();
            } else {
                $_SESSION['error'] = 'Invalid login credentials. Please try again.';
            }
        } else {
            $_SESSION['error'] = 'Staff does not exist.';
        }
    }

    header("LOCATION: " . $_SERVER['REQUEST_URI']);
    exit();
    }
?>
