<?php
session_start();
include("../config/db.php");

$fullname = trim($_POST['fullname']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$role = $_POST['role'];

if (empty($fullname) || empty($email) || empty($password) || empty($role)) {
    die("All fields are required.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email.");
}

if ($role !== "rider" && $role !== "contact") {
    die("Invalid role.");
}

$check = $conn->prepare("SELECT id FROM users WHERE email=?");
$check->bind_param("s", $email);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    die("Email already exists.");
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (fullname,email,password,role) VALUES (?,?,?,?)");
$stmt->bind_param("ssss", $fullname, $email, $hashed, $role);

if ($stmt->execute()) {

    $user_id = $stmt->insert_id;

    if ($role == "rider") {
        $st = $conn->prepare("INSERT INTO rider_status (rider_id,last_location,last_ping,ride_active) VALUES (?, 'No location yet', NOW(), 0)");
        $st->bind_param("i", $user_id);
        $st->execute();
    }

    $_SESSION['user_id'] = $user_id;
    $_SESSION['role'] = $role;

    if ($role == "rider") {
        header("Location: /RIDERS/dashboard-rider.php");
    } else {
        header("Location: /RIDERS/dashboard-contact.php");
    }
    exit();

} else {
    die("Registration failed.");
}
?>
