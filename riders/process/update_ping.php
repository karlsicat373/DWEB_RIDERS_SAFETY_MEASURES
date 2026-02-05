<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "rider") {
    die("Unauthorized");
}

$rider_id = $_SESSION['user_id'];
$location = trim($_POST['location']);

if (empty($location)) {
    die("Location required.");
}

$stmt = $conn->prepare("UPDATE rider_status SET last_location=?, last_ping=NOW() WHERE rider_id=?");
$stmt->bind_param("si", $location, $rider_id);
$stmt->execute();

header("Location: /RIDERS/dashboard-rider.php");
exit();
?>
