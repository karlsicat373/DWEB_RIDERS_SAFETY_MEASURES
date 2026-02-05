<?php
session_start();
include("config/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "rider") {
    header("Location: /RIDERS/login.php");
    exit();
}

$rider_id = $_SESSION['user_id'];

$userQ = $conn->prepare("SELECT fullname,email FROM users WHERE id=?");
$userQ->bind_param("i", $rider_id);
$userQ->execute();
$user = $userQ->get_result()->fetch_assoc();

$msg = "";

if(isset($_POST['contact_email'])) {
    $contact_email = trim($_POST['contact_email']);

    $find = $conn->prepare("SELECT id FROM users WHERE email=? AND role='contact'");
    $find->bind_param("s", $contact_email);
    $find->execute();
    $res = $find->get_result();

    if($res->num_rows == 1) {
        $contact = $res->fetch_assoc();
        $contact_id = $contact['id'];

        $add = $conn->prepare("INSERT IGNORE INTO trusted_contacts (rider_id, contact_id) VALUES (?, ?)");
        $add->bind_param("ii", $rider_id, $contact_id);

        if($add->execute()) {
            $msg = "Trusted contact added successfully!";
        } else {
            $msg = "Failed to add contact.";
        }
    } else {
        $msg = "Contact email not found (must be registered as Contact role).";
    }
}

$list = $conn->prepare("
    SELECT u.fullname, u.email 
    FROM trusted_contacts tc
    JOIN users u ON tc.contact_id = u.id
    WHERE tc.rider_id=?
");
$list->bind_param("i", $rider_id);
$list->execute();
$contacts = $list->get_result();
?>

<?php include "includes/header.php"; ?>
<?php include "includes/navbar.php"; ?>

<section class="dashboard">
    <div class="container">

        <div class="profile-box">
            <div class="info">
                <h2><?php echo htmlspecialchars($user['fullname']); ?>'s Trusted Contacts</h2>
                <p>Add emergency contacts who can monitor your ride status.</p>
            </div>
        </div>

        <?php if($msg != ""): ?>
            <div class="dash-card">
                <p><strong><?php echo htmlspecialchars($msg); ?></strong></p>
            </div>
        <?php endif; ?>

        <div class="dash-grid">

            <div class="dash-card">
                <h3>Add Contact</h3>

                <form method="POST">
                    <div class="input-group">
                        <label>Contact Email</label>
                        <input type="email" name="contact_email" required>
                    </div>

                    <button class="btn btn-primary full" type="submit">Add Trusted Contact</button>
                </form>
            </div>

            <div class="dash-card">
                <h3>Your Contact List</h3>

                <?php if($contacts->num_rows > 0): ?>
                    <ul>
                        <?php while($c = $contacts->fetch_assoc()): ?>
                            <li>👤 <?php echo htmlspecialchars($c['fullname']); ?> (<?php echo htmlspecialchars($c['email']); ?>)</li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No trusted contacts yet.</p>
                <?php endif; ?>
            </div>

        </div>

    </div>
</section>

<?php include "includes/footer.php"; ?>
