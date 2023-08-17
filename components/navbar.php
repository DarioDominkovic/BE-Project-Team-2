<?php
$raus = "../";
$navbar = "
<nav class='navbar navbar-expand-lg bg-body-tertiary'>
    <div class='container-fluid'>
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse justify-content-end' id='navbarSupportedContent'>
            <ul class='navbar-nav me-auto mb-2 mb-lg-0'>";

$navbar .= "
            <img class='logo' src='../pictures/logo.png' alt='Logo'>
            </ul>";

if (isset($_SESSION["user"]) || isset($_SESSION["adm"])) {
    $navbar .= "    
            <ul class='navbar-nav'>
                <li class='nav-item'><a class='nav-link' href='{$raus}index.php'>Activities</a></li>
            </ul>";
}

$navbar .= "
            <ul class='navbar-nav'>";

if (isset($_SESSION["user"])) {
    $id = $_SESSION["user"];
    $navbar .= "
                <li class='nav-item'>
                    <a class='nav-link' href='{$raus}/crud_user/show.php?id=$id'>Profile</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='{$raus}routine.php'>My Routine</a>
                </li>";
}

$navbar .= "
            </ul>";

if (isset($_SESSION["adm"])) {
    $id = $_SESSION["adm"];
    $navbar .= "
            <ul class='navbar-nav'>
                <li class='nav-item'>
                    <a class='nav-link' href='{$raus}dashboard.php'>Dashboard</a>
                </li>
            </ul>";
}

$navbar .= "
            <ul class='navbar-nav'>";

if (isset($_SESSION["user"]) || isset($_SESSION["adm"])) {
    $navbar .= "
                <li class='nav-item'>
                    <a class='logout' href='{$raus}/login/logout.php?logout'>Logout</a>
                </li>";
}

$navbar .= "
            </ul>
        </div>
    </div>
</nav>";
?>
 <head>
  <link rel="stylesheet" href="navbar.css">
</head> 