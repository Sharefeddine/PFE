<?php
$querySI = "SELECT * FROM `settings` where code='1' ";
          $qSI = $conn->query($querySI);
          $qSI->setFetchMode(PDO::FETCH_ASSOC);
            while($row= $qSI->fetch()) {
               $name= $row['name'];
               $address = $row['adresse'];
               $email = $row['email'];
               $fix = "0".$row['fix'];
               $fax = "0".$row['fax'];
               $facebook=$row['facebook'];
               $twiter=$row['twitter'];
               $instagram=$row['instagram'];
               $linkdin=$row['linkdin'];
            }
$lien = "";
$EmailPassword = "sgvlwsqtmwlygecc";
$facebook="";
$twiter="";
?>