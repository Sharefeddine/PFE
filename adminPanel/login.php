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
            <form action="" method="post">
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
    include("../inc/connect.php");
    $email = $_POST["email"];
    $password = md5($_POST["password"]);
    $query = "SELECT * FROM admin WHERE email = '".$email."' AND password = '".$password."'";
    $statement = $conn->prepare($query);
    $statement->execute();
    $count = $statement->rowCount();
    if ($count > 0) {
        $row = $statement->fetch();
        session_start();
        $_SESSION["email"] = $email;
        $_SESSION["fullName"] = $row['fullName'];
        $_SESSION["id"] = $row['id'];
        header('Location:index.php');
        ob_end_flush();
        exit();
    } else {
        echo "<label>ERROR</label>";
    }
}
?>
    <script type="text/javascript" src="style/js/main.js"></script>
</body>
</html>