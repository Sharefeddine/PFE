<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location:login.php');
    exit;
}
include("../inc/connect.php");
 ?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Clients List</title>
     <meta charset="UTF-8">
     <link rel="stylesheet" href="style/css/style.css" type="text/css">
      <link rel="stylesheet" href="style/css/tables.css" type="text/css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
 <?php include("sidemenu.php"); ?>
 <section class="home-section">
 <nav>
 <div class="sidebar-button">
 <i class='bx bx-menu sidebarBtn'></i>
 <span class="dashboard">Clients List</span>
 </div>
 <div class="profile-details"><span class="admin_name"><?php echo($_SESSION['fullName']); ?></span></div>
 </nav>
<div class="home-content">
    <div class="overview-boxes">
        <div class="search-container"><button type="submit" name="add" value="add"  onclick="add()">add</button> <br></div>
    <div>
    <table>
        <thead>
            <th>N°</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Edit</th>
            <th>More Info</th>
        </thead>
        <?php
        $query = 'SELECT * FROM clients c INNER JOIN subscription s ON c.id = s.clientID WHERE s.endDate > CURDATE() ORDER BY s.endDate LIMIT 10;';
        $q = $conn->query($query);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $Count = $q->rowCount();
        $i=1;
        if($Count>0){
        while($row= $q->fetch()){
            echo'<tr>
            <td>'.$i.'</td>
            <td>'.$row['fullname'].'</td>
            <td>'.$row['mobile'].'</td>
            <td>'.$row['email'].'</td>
            <td>'.$row['startDate'].'</td>
            <td>'.$row['endDate'].'</td>
            <td><a href=editClient.php?id='.$row['clientID'].'>Editer</a></td>
            <td><a href=clientMoreInfo.php?id='.$row['clientID'].'>Editer</a></td>
            </tr>';
            }
          }else {
              echo"<td>No data found</td>";
          }
          ?>
          </table>
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
function add() {
  window.location.href = " addClient.php";
}
</script>
</body>

</html>