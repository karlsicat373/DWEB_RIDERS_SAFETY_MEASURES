<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<section class="hero">
    <div class="container">
        <h1>Emergency Safety Check-in System</h1>
        <p>
            A modern safety system designed for riders. Track location, manage trusted contacts,
            and send alerts when needed.
        </p>

        <a href="/RIDERS/register.php" class="btn btn-primary">Get Started</a>
        <a href="#how" class="btn btn-secondary">How It Works</a>
    </div>
</section>

<section class="section" id="how">
    <div class="container">
        <h2>How It Works</h2>

        <div class="grid grid-4">
            <div class="card">
                <div class="icon">👤</div>
                <h3>Create Account</h3>
                <p>Register as a rider or trusted contact to join the safety network.</p>
            </div>

            <div class="card">
                <div class="icon">👥</div>
                <h3>Add Trusted Contacts</h3>
                <p>Riders can assign emergency contacts who can monitor them.</p>
            </div>

            <div class="card">
                <div class="icon">📍</div>
                <h3>Update Location</h3>
                <p>Riders send safety pings and update their current location anytime.</p>
            </div>

            <div class="card">
                <div class="icon">🚨</div>
                <h3>Emergency Monitoring</h3>
                <p>Trusted contacts can view last ping details to ensure rider safety.</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
