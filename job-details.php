<?php
// ============================================
// job-details.php
// Shows full details of ONE job, selected by its ID
// passed through the URL (job-details.php?id=1).
// ============================================
include 'includes/header.php';

// Combine sample jobs + employer-posted jobs so details work for both
$all_jobs = $jobs + $_SESSION['posted_jobs'];

// Get the job id from the URL, e.g. job-details.php?id=2
$job_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Look up the job in our array using its id as the key
$job = $all_jobs[$job_id] ?? null;
?>

<?php if (!$job): ?>
    <div class="alert alert-error">Sorry, that job could not be found.</div>
    <a href="jobs.php" class="btn">Back to Jobs</a>

<?php else: ?>

    <div class="job-details-box">
        <h1 style="color:#1a2b4c;"><?php echo htmlspecialchars($job['title']); ?></h1>
        <p class="job-meta" style="margin:10px 0;">
            <strong><?php echo htmlspecialchars($job['company']); ?></strong> —
            <?php echo htmlspecialchars($job['location']); ?>
        </p>
        <span class="job-type"><?php echo htmlspecialchars($job['type']); ?></span>
        <p style="margin-top:15px;"><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?></p>
        <p style="margin-top:15px;"><strong>Job Description:</strong></p>
        <p><?php echo htmlspecialchars($job['description']); ?></p>

        <div style="margin-top:25px;">
            <a href="apply.php?id=<?php echo $job['id']; ?>" class="btn">Apply Now</a>
            <a href="jobs.php" class="btn btn-outline">Back to Jobs</a>
        </div>
    </div>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
