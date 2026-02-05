<?php
session_start();
include("../config/db.php");

$email = trim($_POST['email']);
$password = $_POST['password'];

if (empty($email) || empty($password)) {
    die("Email and password are required.");
}

$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {

    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == "rider") {
            header("Location: /RIDERS/dashboard-rider.php");
        } else {
            header("Location: /RIDERS/dashboard-contact.php");
        }
        exit();

    } else {
        die("Incorrect password.");
    }

} else {
    die("User not found.");
}
?>
