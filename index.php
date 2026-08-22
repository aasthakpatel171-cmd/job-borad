<?php
// ============================================
// index.php
// Home Page — the first page a visitor sees.
// Introduces the portal and gives quick links.
// ============================================
include 'includes/header.php';
?>

<section class="hero">
    <h1>Find Your Next Job, Simply.</h1>
    <p>Browse jobs posted by companies, apply in a few clicks, or post a job if you're an employer.</p>
    <a href="jobs.php" class="btn">Browse Jobs</a>
    <a href="register.php" class="btn btn-outline">Get Started</a>
</section>

<section>
    <h2 style="color:#1a2b4c; margin-bottom:15px;">Why use this Job Portal?</h2>
    <div class="job-card">
        <div>
            <h3>For Job Seekers</h3>
            <p class="job-meta">Browse available jobs, view full details, and submit your application directly online.</p>
        </div>
    </div>
    <div class="job-card">
        <div>
            <h3>For Employers</h3>
            <p class="job-meta">Log in, post new job openings, and manage the jobs you've listed — all in one dashboard.</p>
        </div>
    </div>
</section>

<section style="margin-top:30px;">
    <h2 style="color:#1a2b4c; margin-bottom:15px;">Latest Jobs</h2>
    <?php
        // Show only the first 3 jobs on the home page as a quick preview
        $preview_jobs = array_slice($jobs, 0, 3, true);
        foreach ($preview_jobs as $job):
    ?>
        <div class="job-card">
            <div>
                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                <p class="job-meta"><?php echo htmlspecialchars($job['company']); ?> — <?php echo htmlspecialchars($job['location']); ?></p>
                <span class="job-type"><?php echo htmlspecialchars($job['type']); ?></span>
            </div>
            <a href="job-details.php?id=<?php echo $job['id']; ?>" class="btn btn-outline">View Details</a>
        </div>
    <?php endforeach; ?>

    <div style="text-align:center; margin-top:15px;">
        <a href="jobs.php" class="btn">See All Jobs</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
