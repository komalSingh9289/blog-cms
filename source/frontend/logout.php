<?php
// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the sign-in page or any other relevant page
header("Location: signin.php");
exit();
?>
