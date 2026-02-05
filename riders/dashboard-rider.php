<?php
session_start();
include("config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "rider") {
    header("Location: /RIDERS/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$userQ = $conn->prepare("SELECT fullname,email FROM users WHERE id=?");
$userQ->bind_param("i", $user_id);
$userQ->execute();
$user = $userQ->get_result()->fetch_assoc();

$statusQ = $conn->prepare("SELECT * FROM rider_status WHERE rider_id=?");
$statusQ->bind_param("i", $user_id);
$statusQ->execute();
$status = $statusQ->get_result()->fetch_assoc();
?>

<?php include "includes/header.php"; ?>
<?php include "includes/navbar.php"; ?>

<section class="dashboard">
    <div class="container">

        <div class="profile-box">
            <div class="info">
                <h2>Welcome, <?php echo htmlspecialchars($user['fullname']); ?> 👋</h2>
                <p><?php echo htmlspecialchars($user['email']); ?> | Rider Account</p>
            </div>
            <div>
                <a href="/RIDERS/profile.php" class="btn btn-secondary">View Profile</a>
            </div>
        </div>

        <h1 class="dash-title">Rider Dashboard</h1>

        <div class="dash-grid">

            <div class="dash-card">
                <h3>Ride Status</h3>
                <p class="<?php echo ($status['ride_active'] == 1) ? "status-active" : "status-inactive"; ?>">
                    <?php echo ($status['ride_active'] == 1) ? "Ride Active" : "Ride Inactive"; ?>
                </p>
                <p>Last Ping: <strong><?php echo date("F d, Y h:i A", strtotime($status['last_ping'])); ?></strong></p>
            </div>

            <div class="dash-card">
                <h3>Update Location</h3>

                <form action="/RIDERS/process/update_ping.php" method="POST">
                    <div class="input-group">
                        <label>Current Location</label>
                        <input type="text" name="location" required>
                    </div>

                    <button type="submit" class="btn btn-primary full">Update Safety Ping</button>
                </form>
            </div>

            <div class="dash-card">
                <h3>Last Known Location</h3>
                <div class="map-placeholder">
                    📍 <?php echo htmlspecialchars($status['last_location']); ?>
                </div>
            </div>

            <div class="dash-card">
                <h3>Trusted Contacts</h3>

                <?php
                $tc = $conn->prepare("
                    SELECT users.fullname, users.email 
                    FROM trusted_contacts 
                    JOIN users ON trusted_contacts.contact_id = users.id
                    WHERE trusted_contacts.rider_id=?
                ");
                $tc->bind_param("i", $user_id);
                $tc->execute();
                $contacts = $tc->get_result();

                if ($contacts->num_rows > 0):
                ?>
                    <ul>
                        <?php while($c = $contacts->fetch_assoc()): ?>
                            <li>👤 <?php echo htmlspecialchars($c['fullname']); ?> (<?php echo htmlspecialchars($c['email']); ?>)</li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No trusted contacts yet.</p>
                    <a href="/RIDERS/trusted-contacts.php" class="btn btn-secondary">Add Contacts</a>
                <?php endif; ?>
            </div>

        </div>

    </div>
</section>

<?php include "includes/footer.php"; ?>
