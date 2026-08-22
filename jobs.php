<?php
// ============================================
// jobs.php
// Browse Jobs Page — shows the full list of jobs.
// Supports a simple keyword search using $_GET.
// ============================================
include 'includes/header.php';

// Combine sample jobs + any jobs the employer posted this session
$all_jobs = $jobs + $_SESSION['posted_jobs'];

// ---- Simple search feature (no database needed) ----
// If user typed something in the search box, filter the array in PHP.
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if ($search !== '') {
    $all_jobs = array_filter($all_jobs, function ($job) use ($search) {
        return stripos($job['title'], $search) !== false
            || stripos($job['company'], $search) !== false
            || stripos($job['location'], $search) !== false;
    });
}
?>

<h1 style="color:#1a2b4c; margin-bottom:15px;">Browse Jobs</h1>

<!-- Search form: uses GET method so the search term shows in the URL -->
<form method="GET" action="jobs.php" style="margin-bottom:25px; display:flex; gap:10px;">
    <input type="text" name="search" placeholder="Search by title, company, or location"
           value="<?php echo htmlspecialchars($search); ?>"
           style="flex:1; padding:10px; border-radius:5px; border:1px solid #ccc;">
    <button type="submit" class="btn">Search</button>
    <?php if ($search !== ''): ?>
        <a href="jobs.php" class="btn btn-outline">Clear</a>
    <?php endif; ?>
</form>

<?php if (count($all_jobs) === 0): ?>
    <div class="alert alert-error">No jobs found matching "<?php echo htmlspecialchars($search); ?>".</div>
<?php else: ?>
    <?php foreach ($all_jobs as $job): ?>
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
            <a href="job-details.php?id=<?php echo $job['id']; ?>" class="btn btn-outline">View Details</a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
