<?php
// ============================================
// post-job.php
// Employer's "Post a Job" form.
// New job is added to $_SESSION['posted_jobs']
// (no database) so it appears in Browse Jobs
// and the dashboard during this session.
// ============================================
// Load session + data BEFORE any HTML is printed, so redirects
// (header()) are still allowed to run if access is denied.
require_once 'includes/data.php';

// ---- Access control: only logged-in employers can post jobs ----
if (!isset($_SESSION['user_email']) || $_SESSION['user_role'] !== 'employer') {
    header("Location: login.php");
    exit;
}

// Now it's safe to print the page HTML (access check passed)
include 'includes/header.php';

$success = false;
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $company     = trim($_POST['company'] ?? '');
    $location    = trim($_POST['location'] ?? '');
    $salary      = trim($_POST['salary'] ?? '');
    $type        = trim($_POST['type'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($title === '' || $company === '' || $location === '' || $description === '') {
        $error = "Please fill in all required fields.";
    } else {
        // Generate a new unique ID by continuing after the sample jobs
        // and any previously posted jobs in this session.
        $existing_ids = array_merge(array_keys($jobs), array_keys($_SESSION['posted_jobs']));
        $new_id = count($existing_ids) > 0 ? max($existing_ids) + 1 : 1;

        $new_job = [
            "id"          => $new_id,
            "title"       => $title,
            "company"     => $company,
            "location"    => $location,
            "salary"      => $salary !== '' ? $salary : "Not disclosed",
            "type"        => $type !== '' ? $type : "Full-Time",
            "description" => $description,
        ];

        // Save the new job into the session array (acts like INSERT, but temporary)
        $_SESSION['posted_jobs'][$new_id] = $new_job;

        $success = true;
    }
}
?>

<div class="form-box">
    <h2>Post a New Job</h2>

    <?php if ($success): ?>
        <div class="alert alert-success">
            ✅ Job posted successfully! It now appears in Browse Jobs.
        </div>
        <a href="employer-dashboard.php" class="btn">Go to Dashboard</a>
        <a href="jobs.php" class="btn btn-outline">View in Browse Jobs</a>

    <?php else: ?>

        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="post-job.php">
            <div class="form-group">
                <label for="title">Job Title *</label>
                <input type="text" id="title" name="title" required
                       value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="company">Company Name *</label>
                <input type="text" id="company" name="company" required
                       value="<?php echo htmlspecialchars($_POST['company'] ?? $_SESSION['user_name']); ?>">
            </div>
            <div class="form-group">
                <label for="location">Location *</label>
                <input type="text" id="location" name="location" required
                       value="<?php echo htmlspecialchars($_POST['location'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="salary">Salary (optional)</label>
                <input type="text" id="salary" name="salary" placeholder="e.g. ₹20,000 - ₹25,000/month"
                       value="<?php echo htmlspecialchars($_POST['salary'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="type">Job Type</label>
                <select id="type" name="type">
                    <option value="Full-Time">Full-Time</option>
                    <option value="Part-Time">Part-Time</option>
                    <option value="Internship">Internship</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Job Description *</label>
                <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
            </div>
            <button type="submit" class="btn" style="width:100%;">Post Job</button>
        </form>

    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
