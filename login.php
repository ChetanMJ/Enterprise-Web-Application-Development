<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h3><a href="home.php">HOME</a></h3><br>
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="" method="post">
            <label>Email</label>
            <input type="text" name="email" value="" required><br><br>

            <label>Password</label>
            <input type="password" name="password" value="" required><br><br>

            <input type="submit" class="btn btn-primary" value="Login">
            <p>Don't have an account? <a href="registration.php">Register now</a>.</p>
        </form>
   
</body>
</html>


<?php

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
}
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $email =  trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $param_password = password_hash($password, PASSWORD_DEFAULT);

    $incorrect_error="";
    
    $conn = mysqli_connect("localhost", "root","","ewd_final_project");
    $sql = "SELECT first_name, last_name, password, email, user_type FROM users WHERE email = '$email';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck == 0){
        echo "Incorrect Email or password ..";
    } else {
        $row = mysqli_fetch_assoc($result);
        if($password != $row["password"]){
            echo "Incorrect Email or password ..";
        } else {
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $row["email"];
            $_SESSION["username"] = $row["first_name"];
            $_SESSION["user_type"] = $row["user_type"];
            $_SESSION["last_name"]= $row["last_name"];

            echo "Welcome ".$_SESSION["username"]." !! ".$_SESSION["id"];

            $fn = $row["first_name"];
            $ln = $row["last_name"];
            $ut = $row["user_type"];
            $eml = $row["email"];
            $sql2 = "INSERT INTO USER_ACTIONS(first_name, last_name, email, user_type, action)values('$fn','$ln','$eml','$ut','login');";
            mysqli_query($conn, $sql2);

            header("location: home.php");
        }
    }
    $conn-> close();
}
?>