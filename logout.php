<?php
session_start();
session_unset();
session_destroy();
echo "Logged out"; // Debugging
header("Location: login.php");
exit;

?>