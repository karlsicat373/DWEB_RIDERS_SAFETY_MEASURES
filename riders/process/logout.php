<?php
session_start();
session_destroy();
header("Location: /RIDERS/login.php");
exit();
?>
