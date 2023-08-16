<?php
$navbar = "
<nav class='navbar navbar-expand-lg bg-body-tertiary'>
    <div class='container-fluid'>
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse justify-content-end' id='navbarSupportedContent'>
            <ul class='navbar-nav me-auto mb-2 mb-lg-0'>";

if (isset($_SESSION["user"]) || isset($_SESSION["adm"])) {
    $navbar .= "
                <li class='nav-item'>
                    <a class='nav-link active' aria-current='page' href='{$raus}index.php'>Activities</a>
                </li>";
}

if (isset($_SESSION["user"])) {
    $id = $_SESSION["user"];
    $navbar .= "
                <li class='nav-item'>
                    <a class='nav-link' href='{$raus}user_account.php?id=$id'>Profile</a>
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
            <li class='nav-item'>
                <a class='nav-link' href='{$raus}user_account.php'>Dashboard</a>
            </li>
            <li class='nav-item'>
                <a class='nav-link' href='{$raus}update_account.php?x={$id}' class='btn btn-primary'>Update My Admin</a>
            </li>";
}

if (isset($_SESSION["user"]) || isset($_SESSION["adm"])) {
    $navbar .= "
            <li class='nav-item'>
                <a class='nav-link' href='{$raus}/login/logout.php?logout'>Logout</a>
            </li>";
}

$navbar .= "
        </div>
    </div>
</nav>";
