<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location:login.php');
    exit;
}
include("../inc/connect.php");
// retrive dates from datbase
$date = isset($_GET['date']) ? $_GET['date'] : date("Y-m-d");
$carID = $_SESSION['carID'];
$queryDate = "SELECT DISTINCT date FROM records WHERE carID = '".$carID."';";
$stmtDate = $conn->prepare($queryDate);
$stmtDate->execute();
$dataDate = $stmtDate->fetchAll(PDO::FETCH_ASSOC);
// Retrive coridnates X and Y from database
$query = "SELECT * from records where carID='".$carID."' and date ='".$date."'";
$stmt = $conn->prepare($query);
$stmt->execute();
$data = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) $data[] = [$row['X'], $row['Y']];
$jsonData = json_encode($data);
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Home</title>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style/css/style.css" type="text/css">
     <link rel="stylesheet" href="style/css/maps.css" type="text/css">
     <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
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
        <form action="map.php" method="post">
        <select name="date">
            <option value="select day" selected="selected">select day</option>
            <?php foreach ($dataDate as $row) echo "<option value='" . $row['date'] . "'>" . $row['date'] . "</option>";?>
             <input type="submit" />
        </select>
        </form>
    </div>
    <div id="map"></div>
  </section>

 <script>
    var coordinates = <?php echo $jsonData; ?>;
    var firstCoordinates = coordinates[0];
    var map = L.map('map').setView([firstCoordinates[0],firstCoordinates[1]], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy',
        maxZoom: 18,
    }).addTo(map);
    // Add markers to the map for each coordinate
    coordinates.forEach(function(coord) {L.marker(coord).addTo(map);});
    // Add polylines to connect the coordinates
    var polyline = L.polyline(coordinates, {color: 'red'}).addTo(map);
    map.fitBounds(polyline.getBounds());
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
</body>
</html>