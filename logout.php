<?php
// ============================================
// logout.php
// Ends the user's session (logs them out)
// and redirects back to the home page.
// ============================================
require_once 'includes/data.php'; // starts/accesses the session

// Clear all session variables
$_SESSION = [];

// Destroy the session completely
session_destroy();

// Redirect to home page
header("Location: index.php");
exit;
?>
