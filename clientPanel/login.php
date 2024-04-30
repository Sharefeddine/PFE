<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
     <link rel="stylesheet" href="style/css/login.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="container">
        <div class="img">
         <img src="style/images/logo.jpg">
        </div>
        <div class="login-content">
            <form  method="post" novalidate="novalidate">
                <h2 class="title">Welcome</h2>
           		<div class="input-div one">
           		   <div class="i"><i class="fas fa-user"></i></div>
           		   <div class="div">
           		   		<h5>Email</h5>
           		   		<input type="text" class="input" name="email" required="required">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"><i class="fas fa-lock"></i></div>
           		   <div class="div">
           		    	<h5>password</h5>
           		    	<input type="password" class="input" name="password" required="required">
            	   </div>
            	</div>
            	<input type="submit" name="login" class="btn" value="login">
            </form>
        </div>
    </div>
  <?php
  ob_start();
if (isset($_POST["login"])) {
   // echo "<script>alert('pressed');</script>";
    include("../inc/connect.php");
    $email = $_POST["email"];
    $password = md5($_POST["password"]);
    $query1 = "SELECT * FROM clients WHERE email = '".$email."' AND password = '".$password."'";
    echo($query1);
    echo "<script>alert('".$query1."');</script>";
    $statement1 = $conn->prepare($query1);
    $statement1->execute();
    $count = $statement1->rowCount();
    if ($count > 0) {
        $row = $statement1->fetch();
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["fullName"] = $row['fullname'];
        $query2 = "SELECT * from subscription where clientID='".$row['id']."'";
        $stmt2 = $conn->prepare($query2);
        $stmt2->execute();
        $row2 = $stmt2->fetch();
        $currentDate = new DateTime();
        $endDate = new DateTime($row2['endDate']);
        if($endDate>$currentDate){
          $_SESSION["carID"] = $row2['carID'];
          header('Location:index.php');
          ob_end_flush();
          exit();
        } else {
            echo "<script>alert('Your subscription has expired! Please contact the nearest agency to renew it. Thank you!');</script>";
        echo "<label></label>";
        }
    } else {
        echo "<script>alert('ERROR');</script>";
    }
}

?>
    <script type="text/javascript" src="style/js/main.js"></script>
</body>
</html>