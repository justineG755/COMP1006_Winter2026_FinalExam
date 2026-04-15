<?php
//start a session
session_start();


//checks if a user session exsists to determine if the user is logged in
if (empty($_SESSION["user_id"])) {
    header('Location:restricted.php');//redrirects unauthorized users to the retricted access page
    exit();
}
?>