<?php
// Starts sessions
session_start();
// Checks if $SESSION['access'] is not set or if not true
if (!isset($_SESSION['access']) || $_SESSION['access'] != true)
{
  header('Location: index.php'); // If either is not true, the user is logged out and does not have access, so they are redirected to the home page.
  exit;
}

?>
