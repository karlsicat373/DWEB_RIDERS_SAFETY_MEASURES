<?php
session_start();
include("config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "contact") {
    header("Location: /RIDERS/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$userQ = $conn->prepare("SELECT fullname,email FROM users WHERE id=?");
$userQ->bind_param("i", $user_id);
$userQ->execute();
$user = $userQ->get_result()->fetch_assoc();

$ridersQ = $conn->prepare("
    SELECT u.fullname, u.email, rs.last_location, rs.last_ping, rs.ride_active
    FROM trusted_contacts tc
    JOIN users u ON tc.rider_id = u.id
    JOIN rider_status rs ON rs.rider_id = u.id
    WHERE tc.contact_id=?
");
$ridersQ->bind_param("i", $user_id);
$ridersQ->execute();
$riders = $ridersQ->get_result();
?>

<?php include "includes/header.php"; ?>
<?php include "includes/navbar.php"; ?>

<section class="dashboard">
    <div class="container">

        <div class="profile-box">
            <div class="info">
                <h2>Welcome, <?php echo htmlspecialchars($user['fullname']); ?> 👋</h2>
                <p><?php echo htmlspecialchars($user['email']); ?> | Emergency Contact</p>
            </div>
        </div>

        <h1 class="dash-title">Emergency Contact Dashboard</h1>

        <div class="dash-grid">

            <?php if($riders->num_rows > 0): ?>
                <?php while($r = $riders->fetch_assoc()): ?>
                    <div class="dash-card">
                        <h3>Rider: <?php echo htmlspecialchars($r['fullname']); ?></h3>
                        <p><?php echo htmlspecialchars($r['email']); ?></p>

                        <p class="<?php echo ($r['ride_active'] == 1) ? "status-active" : "status-inactive"; ?>">
                            <?php echo ($r['ride_active'] == 1) ? "Ride Active" : "Ride Inactive"; ?>
                        </p>

                        <div class="map-placeholder">
                            📍 <?php echo htmlspecialchars($r['last_location']); ?>
                        </div>

                        <p>Last Ping: <strong><?php echo date("F d, Y h:i A", strtotime($r['last_ping'])); ?></strong></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="dash-card">
                    <h3>No Riders Assigned Yet</h3>
                    <p>No riders have added you as a trusted contact.</p>
                </div>
            <?php endif; ?>

        </div>

    </div>
</section>

<?php include "includes/footer.php"; ?>
