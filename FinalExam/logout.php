<?php

// checks if authorized
require "includes/auth.php";
require "includes/header.php";

// clear all session variables by replacing the session array with an empty one
$_SESSION = [];

// unset all session variables currently stored in memory
session_unset();

// destroy the session completely on the server
session_destroy();

// redirect the user back to the login page
header("Location: login.php");

// stop the script from executing any further code
exit;
?> 
