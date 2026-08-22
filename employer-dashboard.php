<?php
// ============================================
// employer-dashboard.php
// Employer's dashboard — shows jobs they've posted
// (stored in session) and applications received.
// Access is restricted to logged-in employers only.
// ============================================
// Load session + data BEFORE any HTML is printed, so that a
// redirect (header()) is still allowed to run if access is denied.
require_once 'includes/data.php';

// ---- Access control: only logged-in employers can view this page ----
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'employer') {
    header("Location: login.php");
    exit;
}

// Now it's safe to print the page HTML (access check passed)
include 'includes/header.php';

// Jobs posted by this employer during this session
$my_posted_jobs = $_SESSION['posted_jobs'];

// Applications received (across all jobs, since this is a simple demo)
$all_applications = $_SESSION['applications'];
?>

<h1 style="color:#1a2b4c;">Employer Dashboard</h1>
<p class="job-meta" style="margin-bottom:20px;">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>.</p>

<div style="margin-bottom:25px;">
    <a href="post-job.php" class="btn">+ Post a New Job</a>
</div>

<h2 style="color:#1a2b4c; margin-bottom:10px;">Your Posted Jobs (<?php echo count($my_posted_jobs); ?>)</h2>

<?php if (count($my_posted_jobs) === 0): ?>
    <div class="alert alert-error">You haven't posted any jobs yet in this session. Click "Post a New Job" above.</div>
<?php else: ?>
    <?php foreach ($my_posted_jobs as $job): ?>
        <div class="job-card">
            <div>
                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                <p class="job-meta">
                    <?php echo htmlspecialchars($job['company']); ?> —
                    <?php echo htmlspecialchars($job['location']); ?> —
                    <?php echo htmlspecialchars($job['salary']); ?>
                </p>
                <span class="job-type"><?php echo htmlspecialchars($job['type']); ?></span>
            </div>
            <a href="job-details.php?id=<?php echo $job['id']; ?>" class="btn btn-outline">View</a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<h2 style="color:#1a2b4c; margin:30px 0 10px;">Applications Received (<?php echo count($all_applications); ?>)</h2>

<?php if (count($all_applications) === 0): ?>
    <div class="alert alert-error">No applications have been submitted yet in this session.</div>
<?php else: ?>
    <?php foreach ($all_applications as $app): ?>
        <div class="job-card">
            <div>
                <h3><?php echo htmlspecialchars($app['name']); ?></h3>
                <p class="job-meta">Applied for: <strong><?php echo htmlspecialchars($app['job_title']); ?></strong></p>
                <p class="job-meta">Email: <?php echo htmlspecialchars($app['email']); ?></p>
                <?php if (!empty($app['message'])): ?>
                    <p class="job-meta">Message: <?php echo htmlspecialchars($app['message']); ?></p>
                <?php endif; ?>
                <span class="job-type"><?php echo htmlspecialchars($app['applied_on']); ?></span>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
