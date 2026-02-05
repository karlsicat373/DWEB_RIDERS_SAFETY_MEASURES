<nav class="navbar">
    <div class="container nav-flex">
        <a href="/RIDERS/index.php" class="logo">
            RiderSafe <span>🚴</span>
        </a>

        <div class="menu-btn">☰</div>

        <div class="nav-links">
            <a href="/RIDERS/index.php">Home</a>

            <?php if(isset($_SESSION['user_id'])): ?>

                <?php if($_SESSION['role'] == "rider"): ?>
                    <a href="/RIDERS/dashboard-rider.php">Dashboard</a>
                    <a href="/RIDERS/trusted-contacts.php">Trusted Contacts</a>
                <?php else: ?>
                    <a href="/RIDERS/dashboard-contact.php">Dashboard</a>
                <?php endif; ?>

                <a href="/RIDERS/profile.php">Profile</a>
                <a href="/RIDERS/process/logout.php" class="btn btn-primary">Logout</a>

            <?php else: ?>
                <a href="/RIDERS/login.php">Login</a>
                <a href="/RIDERS/register.php" class="btn btn-primary">Get Started</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
