<?php include("../inc/websiteInfo.php");?>
<div class="sidebar">
<div class="logo-details">
<i class="fas fa-flask"></i>
<span class="logo_name"><?php echo($name); ?></span>
</div>
<ul class="nav-links">
    <li>
        <a href='index.php'>
        <i class='bx bx-grid-alt' ></i>
        <span class='links_name'>Home</span>
    </a>
    </li>
    <li>
        <a href='stat.php'>
        <i class='bx bx-grid-alt' ></i>
        <span class='links_name'>Stat</span>
        </a>
    </li>
    <li>
        <a href='map.php'>
        <i class='bx bx-grid-alt' ></i>
        <span class='links_name'>Map</span>
        </a>
    </li>
    <li class="log_out">
        <a href="logout.php">
        <i class='bx bx-log-out'></i>
        <span class="links_name">Log out</span>
        </a>
    </li>
</ul>
</div>