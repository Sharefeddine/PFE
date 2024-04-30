<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location:login.php');
    exit;
}
include("../inc/connect.php");
$currentMonth = date('n');
$currentYear = date('Y');
function getData($query,$type){
    include("../inc/connect.php");
    $stmt = $conn->prepare($query);
 $stmt->execute();
 while($row= $stmt->fetch()) {
     if($type=="pa")$data = $row['total_count'];
     else $data = $row['total_sum'];
      }
return $data ;
}
//SELECT Month(t.dateTest) AS total_sum, SUM(an.prixA) AS prixTotal FROM test t INNER JOIN détail_test dt ON dt.numTest = t.numTest INNER JOIN analyse an ON dt.idAnalyse = an.idAnalyse
//SELECT SUM(subquery.count) AS total_count FROM (SELECT DAY(DateR) AS day, COUNT(*) AS count FROM rendez_vous WHERE Month(DateR) = '2' GROUP BY DAY(DateR)) subquery;
$queryRM = "SELECT SUM(subquery.count) AS total_count FROM (SELECT DAY(DateR) AS day, COUNT(*) AS count FROM rendez_vous WHERE Month(DateR) = '".$currentMonth."' GROUP BY DAY(DateR)) subquery";
 $dataMR = getData($queryRM,"pa");
$queryRY = "SELECT SUM(subquery.count) AS total_count FROM ( SELECT DAY(DateR) AS day, COUNT(*) AS count FROM rendez_vous WHERE YEAR(DateR) = '".$currentYear."' GROUP BY DAY(DateR)) subquery";
$dataMY = getData($queryRY,"pa");
$queryINM = "SELECT SUM(subquery.sum) AS total_sum
FROM (
    SELECT SUM(an.prixA) AS sum
    FROM test t
    INNER JOIN détail_test dt ON dt.numTest = t.numTest
    INNER JOIN analyse an ON dt.idAnalyse = an.idAnalyse
    WHERE Month(t.dateTest) = '".$currentMonth."'
    GROUP BY DAY(t.dateTest)
) subquery";
$dataINM = getData($queryINM,"in");
//SELECT SUM(an.prixA) AS prixTotal FROM test t INNER JOIN détail_test dt ON dt.numTest = t.numTest INNER JOIN analyse an ON dt.idAnalyse = an.idAnalyse WHERE MONTH(t.dateTest) = ".$currentMonth.";
//SELECT SUM(subquery.SUM) AS total_sum FROM ( SELECT DAY(DateR) AS day, SUM(invoice) AS SUM FROM rendez_vous WHERE YEAR(DateR) = '".$currentYear."' GROUP BY DAY(DateR)) subquery
$queryINY = "SELECT SUM(an.prixA) AS total_sum
FROM test t
INNER JOIN détail_test dt ON dt.numTest = t.numTest
INNER JOIN analyse an ON dt.idAnalyse = an.idAnalyse
WHERE YEAR(t.dateTest) =  '".$currentYear."'";
$dataINY = getData($queryINY,"in");
?>
<!DOCTYPE HTML>

<html>
<head>
    <title>Page d'accuile</title>
     <meta charset="UTF-8">
     <link rel="stylesheet" href="style/css/style.css" type="text/css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style/css/tables.css" type="text/css">
</head>
<body>
    <style>
    .tabless{
       width: 100%;
    }

    </style>
<?php include("sidemenu.php"); ?>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Page d'accuile</span>
      </div>
      <div class="profile-details">
                <span class="admin_name"><?php echo($_SESSION['nom_c']);?></span>
            </div>
    </nav>
    <div class="home-content">
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Patients<br> ce mois-ci</div>
            <div class="number"><?php echo($dataMR); ?></div>
          </div>
          </div>
         <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Patients<br>cette année</div>
            <div class="number"><?php echo($dataMY); ?></div>
          </div>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Bénéfice total<br> ce mois-ci</div>
            <div class="number"><?php echo($dataINM); ?>DA</div>
          </div>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Bénéfice total<br>cette année</div>
            <div class="number"><?php echo($dataINY); ?> DA</div>
          </div>
        </div>
      </div>
      <div class="sales-boxes">
        <div class="recent-sales box">
            <div class="tabless">
                 <div class="title">Rendez-vous récent</div>
          <div class="sales-details">
           <table>
               <tr>
                   <td>Nom</td>
                   <td>email</td>
                   <td>mobile</td>
                   <td>date</td>
               </tr>
        <?php
         $query= "select * from patient p INNER JOIN rendez_vous r on p.idPatient=r.idPatient ORDER BY `r`.`idPatient` DESC LIMIT 10;";
          $q = $conn->query($query);
          $q->setFetchMode(PDO::FETCH_ASSOC);
          $Count = $q->rowCount();
          if($Count>0)  {
            while($row= $q->fetch()) {
                $nom = $row['nomP'].' '.$row['prénomP'];
                 echo '<tr>
        <td>'.$nom.'</td>
        <td>'.$row['emailP'].'</td>
        <td>'.$row['télP'].'</td>
        <td>'.$row['dateR'].'/'.$row['heureR'].'</td>
      </tr>';
                 }
          }else {
          echo"<tr><td>Aucune donnée disponible</td></tr>";
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