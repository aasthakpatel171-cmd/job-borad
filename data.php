<?php
// ============================================
// data.php
// This file stores sample job data using a PHP array.
// Since the project does NOT use a database,
// this array acts like a simple "table" of jobs.
// ============================================

// Start session on every page that includes this file
// (session is needed for login status and temporary data)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ---- Sample Job Listings (like rows in a database table) ----
// Each job is an associative array with: id, title, company, location, salary, type, description

$jobs = [
    1 => [
        "id" => 1,
        "title" => "PHP Web Developer",
        "company" => "TechNova Solutions",
        "location" => "Ahmedabad",
        "salary" => "₹25,000 - ₹35,000/month",
        "type" => "Full-Time",
        "description" => "We are looking for a PHP developer to build and maintain web applications. Must know HTML, CSS, PHP basics."
    ],
    2 => [
        "id" => 2,
        "title" => "Frontend Developer",
        "company" => "PixelCraft Studio",
        "location" => "Surat",
        "salary" => "₹20,000 - ₹30,000/month",
        "type" => "Full-Time",
        "description" => "Looking for someone skilled in HTML, CSS, and JavaScript to design responsive websites."
    ],
    3 => [
        "id" => 3,
        "title" => "IT Support Intern",
        "company" => "InfoBridge Pvt Ltd",
        "location" => "Vadodara",
        "salary" => "₹8,000/month (Stipend)",
        "type" => "Internship",
        "description" => "Internship opportunity for IT students to learn hands-on system and network support."
    ],
    4 => [
        "id" => 4,
        "title" => "Data Entry Operator",
        "company" => "Global Records Co.",
        "location" => "Rajkot",
        "salary" => "₹12,000 - ₹15,000/month",
        "type" => "Part-Time",
        "description" => "Simple data entry work, good typing speed required. Basic computer knowledge needed."
    ],
    5 => [
        "id" => 5,
        "title" => "Junior Software Tester",
        "company" => "QualityFirst Systems",
        "location" => "Ahmedabad",
        "salary" => "₹18,000 - ₹22,000/month",
        "type" => "Full-Time",
        "description" => "Entry level QA role to test websites and applications for bugs before release."
    ],
];

// ---- Simple fixed login credentials (demo only, no database) ----
// In a real project, this would come from a database with hashed passwords.
$demo_users = [
    "seeker@example.com"  => ["password" => "seeker123",  "role" => "seeker",  "name" => "Aman Seeker"],
    "employer@example.com" => ["password" => "employer123", "role" => "employer", "name" => "Priya Employer"],
];

// ---- Temporary storage for jobs posted by employer during this session ----
// This lets the employer "post a job" and see it added to the list,
// without needing a real database. It resets when the session ends.
if (!isset($_SESSION['posted_jobs'])) {
    $_SESSION['posted_jobs'] = [];
}

// ---- Temporary storage for job applications submitted during this session ----
if (!isset($_SESSION['applications'])) {
    $_SESSION['applications'] = [];
}
?>
