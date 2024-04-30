<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location:login.php');
    exit;
}

include("functions.php");
include("../inc/connect.php");
$carID = $_SESSION['carID'];
$queryToday = "SELECT * FROM records WHERE carID = '".$carID."' AND date = CURDATE()";
$distanceToday = getData($queryToday) ;
$queryWeek = "SELECT * FROM records WHERE carID = '".$carID."' AND WEEK(date) = WEEK(NOW())";;
$distanceWeek = getData($queryWeek) ;
$queryMonth = "SELECT * FROM records WHERE carID = '".$carID."' AND MONTH(date) = MONTH(NOW())";
$distanceMonth = getData($queryMonth) ;
$queryYear = "SELECT * FROM records WHERE carID = '".$carID."' AND YEAR(date) = YEAR(NOW())";
$distanecYear = getData($queryYear) ;
function getData($query){
    include("../inc/connect.php");
    $stmtData = $conn->prepare($query);
    $stmtData->execute();
    $dataData = $stmtData->fetchAll(PDO::FETCH_ASSOC);
    $data = [];
    foreach ($dataData as $row) {
        $data[] = [$row['X'], $row['Y']];
    }
    return  calculateDistances($data);
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Home Page</title>
     <meta charset="UTF-8">
     <link rel="stylesheet" href="style/css/style.css" type="text/css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php include("sidemenu.php"); ?>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Home</span>
      </div>
      <div class="profile-details">
                <span class="admin_name"><?php echo($_SESSION['fullName']);?></span>
            </div>
    </nav>
    <div class="home-content">
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Distance<br>today</div>
            <div class="number"><?php echo($distanceToday); ?> KM</div>
          </div>
          </div>
         <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Distance<br>this week</div>
            <div class="number"><?php echo($distanceWeek); ?>  KM</div>
          </div>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Distance<br>this month</div>
            <div class="number"><?php echo($distanceMonth); ?>  KM</div>
          </div>
        </div>
        <div class="box">
        <div class="right-side">
        <div class="box-topic">Total Distance<br>this year</div>
        <div class="number"><?php echo($distanecYear); ?> KM</div>
        </div>
        </div>
      </div>
    </div>
  </section>
  <script>
   let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
  sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
}else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}
 </script>
</body>
</html>