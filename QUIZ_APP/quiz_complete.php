<?php
session_start();

// Mark quiz as completed
unset($_SESSION['quiz_in_progress']);
$_SESSION['quiz_completed'] = true;

echo "done";
?>
