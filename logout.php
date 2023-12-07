<?php

include './includes/header.php'; 
unset($_SESSION['employee_id']);
session_unset();
session_destroy();
header("Location: login.php");

?>
