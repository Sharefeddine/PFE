<!DOCTYPE html>
 <?php
 session_start();
if (!isset($_SESSION['email'])) {
    header('Location:login.php');
    exit;
}
 include("../inc/connect.php");
 include("../inc/functions/functions.php");
 include("../inc/functions/sqlFunctions.php");
 include("../inc/functions/webSiteInformations.php");
  ?>
<html>

<head>
  <title>Parametres</title>
<link rel="stylesheet" href="style/css/style.css" type="text/css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style/css/forms.css" type="text/css">
</head>
<body>
   <?php include("sidemenu.php"); ?>
   <section class="home-section">
 <nav>
 <div class="sidebar-button">
 <i class='bx bx-menu sidebarBtn'></i>
 <span class="dashboard">Parametres</span>
 </div>
            <div class="profile-details">
                <span class="admin_name"><?php echo($_SESSION['nom_c']);?></span>
            </div>
  </nav>
    <div class="home-content">
          <div>
             <form action="" method="post">
                  <table>

                      <tr>
                          <td>Nom</td>
                          <td><input type="text" name="nom" required="required" value="<?php echo($nomLabo); ?>"/></td>
                      </tr>
                      <tr>
                          <td>Email :</td>
                          <td><input type="email" name="email" required="required" value="<?php echo($emailLabo); ?>"/></td>
                      </tr>
                        <tr>
                          <td>Fax :</td>
                          <td><input type="text" name="fax" required="required" value="<?php echo($faxLabo); ?>"/></td>
                      </tr>
                      <tr>
                          <td>Fix :</td>
                          <td><input type="text" name="fix" required="required"  maxlength="10" value="<?php echo($fixeLabo); ?>"/></td>
                      </tr>
                      <tr>
                          <td>tel :</td>
                          <td><input type="text" name="tel" required="required"  maxlength="10" value="<?php echo($telLabo); ?>"/></td>
                      </tr>
                      <tr>
                          <td>Address :</td>
                          <td><input type="text" name="address" required="required" value="<?php echo($addressL); ?>"  /></td>
                      </tr>
                      <tr>
                          <td>Logo:</td>
                          <td><input type="text" name="logo" required="required" value="<?php echo($LogoL); ?>"/></td>
                      </tr>
                      <tr>
                          <td>Ville:</td>
                          <td><?php getVilles($villeL) ?></td>
                      </tr>

                      <tr>
                          <td><button type="submit" name="edit">Edit</button></td>
                      </tr>
                  </table>
              </form>
          </div></div>
  </section>
  <?php
    if(isset($_POST['edit'])){
      $logo = $_POST['logo'];
      $adress = $_POST['address'];
      $fix = $_POST['fix'];
      $fax = $_POST['fax'];
      $tel = $_POST['tel'];
      $email = $_POST['email'];
      $ville = $_POST['ville'];
      $nom = $_POST['nom'];
      $sql =" UPDATE `labortoire` SET addressLabo=?,télLabo=?,emailLabo=?,faxLabo=?,fixeLabo=?,logoLabo=?,nomLabo=?,villeLabo=? WHERE codeLabo='1'" ;
$stmt= $conn->prepare($sql);
$stmt->execute([$adress, $tel, $email, $fax,$fix,$logo,$nom,$ville]);
if($stmt){
    echo"<div class='success-msg'>Les informations des siteweb ont été mises à jour avec succès</div>";
} else {
    echo"<div class='error-msg'>ERROR.</div>";
}
    }
  ?>
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
 <script>
 function show() {
  var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
 </script>
</body>
</html>