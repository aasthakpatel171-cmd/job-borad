<?php
// ============================================
// header.php
// Common top section shown on every page:
// site logo/title + navigation menu.
// Included using: include 'includes/header.php';
// ============================================

// Make sure session + data are available on every page
require_once __DIR__ . '/data.php';

// Check if user is logged in (session variable set during login.php)
$is_logged_in = isset($_SESSION['user_email']);
$user_role    = $_SESSION['user_role'] ?? '';
$user_name    = $_SESSION['user_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <link rel="stylesheet" href="includes/style.css">
</head>
<body>

<header class="site-header">
    <div class="container header-inner">
        <a href="index.php" class="logo">Job<span>Portal</span></a>

        <nav class="nav-menu">
            <a href="index.php">Home</a>
            <a href="jobs.php">Browse Jobs</a>

            <?php if ($is_logged_in && $user_role === 'employer'): ?>
                <a href="employer-dashboard.php">Dashboard</a>
                <a href="post-job.php">Post a Job</a>
            <?php endif; ?>

            <?php if ($is_logged_in): ?>
                <span class="nav-user">Hi, <?php echo htmlspecialchars($user_name); ?></span>
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="container main-content">
