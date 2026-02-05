<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<section class="auth-wrapper">

    <div class="auth-left">
        <h1>Join RiderSafe</h1>
        <p>Create an account and build your safety network.</p>
    </div>

    <div class="auth-right">
        <div class="auth-card">
            <h2>Create Account</h2>

            <form action="/RIDERS/process/register_process.php" method="POST">

                <div class="input-group">
                    <label>Full Name</label>
                    <input type="text" name="fullname" required>
                </div>

                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <div class="role-select">
                    <label>
                        <input type="radio" name="role" value="rider" checked> Rider
                    </label>
                    <label>
                        <input type="radio" name="role" value="contact"> Contact
                    </label>
                </div>

                <button class="btn btn-primary full" type="submit">Register</button>

                <p class="auth-link">
                    Already have an account?
                    <a href="/RIDERS/login.php">Login</a>
                </p>

            </form>
        </div>
    </div>

</section>

<?php include 'includes/footer.php'; ?>
