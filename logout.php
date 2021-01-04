<?php
// Initialize the session
session_start();
$conn = mysqli_connect("localhost", "root","","ewd_final_project");
$fn = $_SESSION["username"];
$ln = $_SESSION["last_name"];
$ut = $_SESSION["user_type"];
$eml = $_SESSION["id"];
$sql2 = "INSERT INTO USER_ACTIONS(first_name, last_name, email, user_type, action)values('$fn','$ln','$eml','$ut','logout');";
mysqli_query($conn, $sql2);

$conn-> close();
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: home.php");
exit;
?>
