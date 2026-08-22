<?php
// ============================================
// apply.php
// Job Application Page.
// Shows a form for the job seeker to apply.
// On submit, stores the application in the SESSION
// (not a database) and shows a success message.
// ============================================
include 'includes/header.php';

// Combine sample jobs + employer-posted jobs
$all_jobs = $jobs + $_SESSION['posted_jobs'];

// Get job id from URL (apply.php?id=1) or from the hidden form field on POST
$job_id = isset($_GET['id']) ? (int) $_GET['id'] : (int) ($_POST['job_id'] ?? 0);
$job    = $all_jobs[$job_id] ?? null;

$success = false;
$error   = '';

// If logged in as a job seeker, pre-fill name/email from session
$is_seeker     = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'seeker';
$prefill_name  = $is_seeker ? ($_SESSION['user_name'] ?? '') : '';
$prefill_email = $is_seeker ? ($_SESSION['user_email'] ?? '') : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $job) {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '') {
        $error = "Please fill in your name and email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        // Save this application into the session (temporary storage, no database)
        $_SESSION['applications'][] = [
            "job_id"    => $job['id'],
            "job_title" => $job['title'],
            "name"      => $name,
            "email"     => $email,
            "message"   => $message,
            "applied_on" => date("d-M-Y H:i"),
        ];
        $success = true;
    }
}
?>

<?php if (!$job): ?>
    <div class="alert alert-error">Sorry, that job could not be found.</div>
    <a href="jobs.php" class="btn">Back to Jobs</a>

<?php else: ?>

    <div class="form-box">
        <h2>Apply for: <?php echo htmlspecialchars($job['title']); ?></h2>
        <p class="job-meta" style="margin-bottom:15px;">
            <?php echo htmlspecialchars($job['company']); ?> — <?php echo htmlspecialchars($job['location']); ?>
        </p>

        <?php if ($success): ?>
            <!-- ===== APPLICATION SUCCESS MESSAGE ===== -->
            <div class="alert alert-success">
                ✅ Application submitted successfully! The company will contact you if shortlisted.
            </div>
            <a href="jobs.php" class="btn">Back to Jobs</a>

        <?php else: ?>

            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="apply.php">
                <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required
                           value="<?php echo htmlspecialchars($_POST['name'] ?? $prefill_name); ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required
                           value="<?php echo htmlspecialchars($_POST['email'] ?? $prefill_email); ?>">
                </div>
                <div class="form-group">
                    <label for="message">Cover Message (optional)</label>
                    <textarea id="message" name="message" rows="4"
                              placeholder="Why are you a good fit for this job?"><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                </div>
                <button type="submit" class="btn" style="width:100%;">Submit Application</button>
            </form>

        <?php endif; ?>
    </div>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
