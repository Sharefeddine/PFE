<?php
$querySI = "SELECT * FROM `settings` where id='1' ";
          $qSI = $conn->query($querySI);
          $qSI->setFetchMode(PDO::FETCH_ASSOC);
            while($row= $qSI->fetch()) {
               $name= $row['name'];
               $address = $row['address'];
               $email = $row['email'];
               $fix = "0".$row['fix'];
               $fax = "0".$row['fax'];
               $facebook=$row['facebook'];
               $twitter=$row['twitter'];
               $instagram=$row['instagram'];
               $linkedin=$row['linkedin'];
            }
$link = "";
$EmailPassword = "sgvlwsqtmwlygecc";
?>