<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location:login.php');
    exit;
}
include("../inc/connect.php");
include("functions.php");
// Retrieve dates from database
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m');
$carID = $_SESSION['carID'];
$queryDate = "SELECT DISTINCT DATE_FORMAT(date, '%Y-%m') AS date FROM records WHERE carID = '".$carID."' AND DATE_FORMAT(date, '%Y-%m') = '".$date."';";
$stmtDate = $conn->prepare($queryDate);
$stmtDate->execute();
$dataDate = $stmtDate->fetchAll(PDO::FETCH_ASSOC);
// Retrieve coordinates X and Y from the database
$queryDays = "SELECT DISTINCT date FROM records WHERE carID = '1' AND DATE_FORMAT(date, '%Y-%m') = '".$date."';";
$stmtDays = $conn->prepare($queryDays);
$stmtDays->execute();
$dataDays = $stmtDays->fetchAll(PDO::FETCH_ASSOC);
$dataPoints = array();
foreach($dataDays as $row){
    $queryData = "SELECT * FROM records WHERE carID = '".$carID."' AND date = '".$row['date']."'";
    $stmtData = $conn->prepare($queryData);
    $stmtData->execute();
    $dataData = $stmtData->fetchAll(PDO::FETCH_ASSOC);
    $data = [];
    foreach ($dataData as $row) {
        $data[] = [$row['X'], $row['Y']];
    }
    $dataPoint = array("y" => calculateDistances($data), "label" => $row['date']);
    array_push($dataPoints, $dataPoint);
}
 $title= "Disatance in ".$date;
 $titleY= "distance (KM)";
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Stat</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/css/style.css" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>
</head>
<body>
<?php include("sidemenu.php"); ?>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Stat</span>
      </div>
      <div class="profile-details">
                <span class="admin_name"><?php echo($_SESSION['fullName']);?></span>
            </div>
    </nav>
    <div class="home-content">
               <form action="stat.php" method="post">
        <select name="date">
            <option value="select month" selected="selected">select month</option>
            <?php foreach ($dataDate as $row) echo "<option value='" . $row['date'] . "'>" . $row['date'] . "</option>";?>
             <input type="submit" />
        </select>
    </form>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    </div>
  </section>
 <script>
window.onload = function() {
var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    theme: "light2",
    zoomEnabled: true,
    title: {text: "<?php  echo($title) ?>"},
    axisY: {
        title: "<?php echo $titleY; ?>",
        titleFontSize: 24,
        prefix: "KM"
    },
    data: [{
        type: "line",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
    }]
});
chart.render();
}
</script>
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
 <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>