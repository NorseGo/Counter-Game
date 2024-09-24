<?php
session_start();

// Zrušení nastavení všech proměnných relace
$_SESSION = array();

// Zničit session
session_destroy();

// Přesměrování do login
header("Location: login.php");
exit();
?>
