<?php


Session::init();

if (isset($_SESSION['users']) && isset($_SESSION['userType'])) {
    $user = Session::get('users');
    $userType = Session::get('userType');
} else {
    header("Location: " . LOGIN);
    exit;
}

if ($userType['name'] === "superadmin") {
    include('superadmin.php');
} elseif ($userType['name'] === "admin") {
    include('admin.php');
} elseif ($userType['name'] === "staff") {
    include('staff.php');
} elseif ($userType['name'] === "company") {
    include('company.php');
} else {
    header('Location: ' . ERROR);
    exit;
}


?>