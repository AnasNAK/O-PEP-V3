<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Regenerate the session ID for enhanced security
session_regenerate_id(true);

// Redirect to the login page
header("Location: ../view/SingIn.php");
exit;
?>
