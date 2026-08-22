<?php
// ============================================
// login.php
// Simple Login Page.
// No database — checks entered email/password
// against the $demo_users array from data.php.
// On success, stores login info in $_SESSION.
// ============================================
// IMPORTANT: We load data.php (session + $demo_users) directly here,
// and handle any redirect BEFORE including header.php.
// Reason: header.php already prints HTML (<!DOCTYPE>, nav bar, etc).
// In PHP, header("Location: ...") MUST run before any HTML output,
// otherwise you get a "headers already sent" error.
require_once 'includes/data.php';

$error = '';

// If the login form was submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Check if this email exists in our demo_users array
    if (isset($demo_users[$email]) && $demo_users[$email]['password'] === $password) {
        // Correct login — save details in the session
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role']  = $demo_users[$email]['role'];
        $_SESSION['user_name']  = $demo_users[$email]['name'];

        // Redirect employer to dashboard, job seeker to jobs page
        if ($demo_users[$email]['role'] === 'employer') {
            header("Location: employer-dashboard.php");
        } else {
            header("Location: jobs.php");
        }
        exit;
    } else {
        $error = "Invalid email or password. Please try again.";
    }
}

// Only now, after any redirect has happened, do we output the page HTML.
include 'includes/header.php';
?>

<div class="form-box">
    <h2>Login</h2>

    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required
                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn" style="width:100%;">Login</button>
    </form>

    <p style="margin-top:15px; font-size:13px; color:#666;">
        <strong>Demo Accounts</strong><br>
        Job Seeker: seeker@example.com / seeker123<br>
        Employer: employer@example.com / employer123
    </p>

    <p style="margin-top:10px; font-size:14px;">
        Don't have an account? <a href="register.php">Register here</a>
    </p>
</div>

<?php include 'includes/footer.php'; ?>
