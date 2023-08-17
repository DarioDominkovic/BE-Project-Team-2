<?php
$raus = "../";
$navbar = "
        <header>
            <img class='logo' src='../pictures/logo.png' alt='Logo'>
            <nav>
                <ul class='nav_links'>";

if (isset($_SESSION["user"]) || isset($_SESSION["adm"])) {
    $navbar .= "
                    <li><a href='{$raus}index.php'>Activities</a></li>";
}

if (isset($_SESSION["user"])) {
    $id = $_SESSION["user"];
    $navbar .= "
                    <li><a href='{$raus}/crud_user/show.php?id=$id'>Profile</a></li>
                    <li><a href='{$raus}routine.php'>My Routine</a></li>";
}

if (isset($_SESSION["adm"])) {
    $id = $_SESSION["adm"];
    $navbar .= "
                    <li><a href='{$raus}dashboard.php'>Dashboard</a></li>";
}

$navbar .= "
                </ul>
            </nav>";
if (isset($_SESSION["user"]) || isset($_SESSION["adm"])) {
    $navbar .= "
    <button>
    <a class='logout' href='{$raus}/login/logout.php?logout'>Logout</a> 
    </button>";
}

$navbar .= "
        </header>";
?>
