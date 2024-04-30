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
    <title>Home Page</title>
     <meta charset="UTF-8">
     <link rel="stylesheet" href="style/css/style.css" type="text/css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style/css/tables.css" type="text/css">
</head>
<body>
<style>.tabless{width: 100%;}</style>
<?php include("sidemenu.php"); ?>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Home Page</span>
      </div>
      <div class="profile-details"><span class="admin_name"><?php echo($_SESSION['fullName']);?></span></div>
    </nav>
    <div class="home-content">
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Active Clients<br></div>
            <div class="number"><?php echo($dataMR); ?></div>
          </div>
          </div>
         <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Added Clients<br>today</div>
            <div class="number"><?php echo($dataMY); ?></div>
          </div>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Active Clients<br> this month</div>
            <div class="number"><?php echo($dataINM); ?>DA</div>
          </div>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Active Clients<br>this year</div>
            <div class="number"><?php echo($dataINY); ?> DA</div>
          </div>
        </div>
      </div>
      <div class="sales-boxes">
        <div class="recent-sales box">
            <div class="tabless">
                 <div class="title">Recent Clients</div>
          <div class="sales-details">
           <table>
               <tr>
                   <td>Nom</td>
                   <td>email</td>
                   <td>mobile</td>
                   <td>date</td>
               </tr>
        <?php
         $query= "SELECT * FROM clients c INNER JOIN subscription s ON c.id = s.clientID WHERE s.endDate > CURDATE() ORDER BY s.startDate LIMIT 10;";
          $q = $conn->query($query);
          $q->setFetchMode(PDO::FETCH_ASSOC);
          $Count = $q->rowCount();
          if($Count>0)  {
            while($row= $q->fetch()) {
            echo '<tr>
            <td>'.$row['name'].'</td>
            <td>'.$row['email'].'</td>
            <td>'.$row['mobile'].'</td>
            </tr>';
            }
          }else {
          echo"<tr><td>No data</td></tr>";
          }
        ?>
           </table>
        </div>
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