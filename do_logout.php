<?php
$pass = strtoupper($_POST['pass']);
require "classes/classes.php";
session_start();
$_SESSION['pass'] = "X";
header("Location: mngr_login.php");
?>