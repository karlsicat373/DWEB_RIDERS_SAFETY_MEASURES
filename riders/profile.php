<?php
session_start();
include("config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: /RIDERS/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT fullname,email,role,created_at FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<?php include "includes/header.php"; ?>
<?php include "includes/navbar.php"; ?>

<section class="dashboard">
    <div class="container">

        <h1 class="dash-title">My Profile</h1>

        <div class="dash-grid">
            <div class="dash-card">
                <h3>Account Information</h3>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($user['fullname']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Role:</strong> <?php echo strtoupper(htmlspecialchars($user['role'])); ?></p>
                <p><strong>Created:</strong> <?php echo date("F d, Y", strtotime($user['created_at'])); ?></p>
            </div>

            <div class="dash-card">
                <h3>Quick Links</h3>

                <?php if($user['role'] == "rider"): ?>
                    <a href="/RIDERS/dashboard-rider.php" class="btn btn-secondary full">Go to Rider Dashboard</a>
                    <br><br>
                    <a href="/RIDERS/trusted-contacts.php" class="btn btn-primary full">Manage Trusted Contacts</a>
                <?php else: ?>
                    <a href="/RIDERS/dashboard-contact.php" class="btn btn-secondary full">Go to Contact Dashboard</a>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>

<?php include "includes/footer.php"; ?>
