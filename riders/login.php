<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<section class="auth-wrapper">

    <div class="auth-left">
        <h1>Welcome Back</h1>
        <p>Login and continue your safety monitoring.</p>
    </div>

    <div class="auth-right">
        <div class="auth-card">
            <h2>Login</h2>

            <form action="/RIDERS/process/login_process.php" method="POST">

                <div class="input-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required>
                </div>

                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <button class="btn btn-primary full" type="submit">Login</button>

                <p class="auth-link">
                    Don’t have an account?
                    <a href="/RIDERS/register.php">Register</a>
                </p>

            </form>
        </div>
    </div>

</section>

<?php include 'includes/footer.php'; ?>
