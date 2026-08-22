<?php
// ============================================
// register.php
// Simple Registration Page.
// Since we don't use a database, submitted data
// is NOT permanently saved — this page simply
// validates the form and shows a success message.
// This is normal and acceptable for a demo project.
// ============================================
include 'includes/header.php';

$success = false;
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role     = trim($_POST['role'] ?? '');

    // Basic validation
    if ($name === '' || $email === '' || $password === '' || $role === '') {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        // In a real project, this is where we would INSERT into a database.
        // Here, we just confirm success to the user (demo only).
        $success = true;
    }
}
?>

<div class="form-box">
    <h2>Register</h2>

    <?php if ($success): ?>
        <div class="alert alert-success">
            Registration successful! You can now <a href="login.php">log in</a>.
            <br><small>(Note: This is a demo — use the demo accounts on the login page to actually sign in.)</small>
        </div>
    <?php else: ?>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required
                       value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Register as</label>
                <select id="role" name="role" required>
                    <option value="">-- Select --</option>
                    <option value="seeker">Job Seeker</option>
                    <option value="employer">Employer</option>
                </select>
            </div>
            <button type="submit" class="btn" style="width:100%;">Register</button>
        </form>

        <p style="margin-top:10px; font-size:14px;">
            Already have an account? <a href="login.php">Login here</a>
        </p>

    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
