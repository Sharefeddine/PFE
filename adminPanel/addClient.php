<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location:login.php');
    exit;
}
include("../inc/connect.php");
include("functions.php");
?>
<!DOCTYPE HTML>

<html>

<head>
    <title>Add Client</title>
    <link rel="stylesheet" href="style/css/style.css" type="text/css">
     <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <link rel="stylesheet" href="style/css/messages.css" type="text/css">
     <link rel="stylesheet" href="style/css/forms.css" type="text/css">
     <link rel="stylesheet" type="text/css" href="style/css/form.css">
</head>

<body>
    <style>

</style>
   <?php include("sidemenu.php"); ?>
   <section class="home-section">
 <nav>
 <div class="sidebar-button">
 <i class='bx bx-menu sidebarBtn'></i>
 <span class="dashboard">Add Client</span>
 </div>
 <div class="profile-details"><span class="admin_name"><?php echo($_SESSION['fullName']);?></span></div>
  </nav>
    <div class="home-content">
        <div class="sales-boxes">
            <div class="overview-boxes">
    <form action="" method="post">
        <label>Full Name</label>
        <input type="text" name="fullname"   /><br>
        <label for="">Mobile</label>
        <input type="text" name="mobile"   /><br>
        <label>Email</label>
        <input type="text" name="email"   /><br><br>
        <label for="">BirthDate</label>
        <input  type="date" name="birthdate" max="<?php echo(date("Y-m-d")); ?>" min="<?php echo(getDateBefore70Years()); ?>"  /><br>
        <label for="">carID</label>
        <input type="number" name="carID" maxlength="10"/><br>
          <label for="">Address</label>
        <input type="text" name="address"   /><br>
        <button type="submit" name="Add">Add</button>
       </form>
<?php
if(isset($_POST['Add'])){
    $fullname= $_POST['fullname'];
    $mobile=$_POST['mobile'] ;
    $email=$_POST['email'];
    $birthdate=$_POST['birthdate'];
    $carID=$_POST['carID'];
    $address =  $_POST['address'];
    $startDate = date("Y-m-d");
    $endDate = date("Y-m-d", strtotime($startDate . " +1 year"));
    $sqlC = "INSERT INTO `clients` (`fullname`, `email`, `mobile`, `birthDate`, `address`, `password`) VALUES (?,?,?,?,?,?);";
    $stmtC = $conn->prepare($sqlC);
    $stmtC->execute([$fullname, $email, $mobile, $birthdate, $address, generateRandomCode()]);
    if($stmtC){
    $sqlS = "INSERT INTO `subscription` (`clientID`, `startDate`, `endDate`, `carID`) VALUES (?,?,?,?);";
    $stmtS = $conn->prepare($sqlS);
    $clientID = $conn->lastInsertId();
    $stmtS->execute([$clientID, $startDate, $endDate,$carID]);
    if($stmtS){
        echo"<div class='success-msg'>Client has added succfully</div>";
        header("Refresh: 5; url=clientsLists.php");
        ob_end_flush();
        exit();
    }else echo"<div class='error-msg'>ERROR</div>";
    } else echo"<div class='error-msg'>ERROR</div>";

}
?>
        </div>
        </div>
      </div>
  </section>
<script>
let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
sidebar.classList.toggle("active");
if(sidebar.classList.contains("active"))sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}
</script>
</body>
</html>