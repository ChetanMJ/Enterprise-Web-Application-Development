<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
</head>
<body>
<h3><a href="home.php">HOME</a></h3><br>
        <h2>Register</h2>
        <p>Please fill this form to create an account.</p>
        <form action="" method="post">
                <label>First Name</label>
                <input type="text" name="first_name" value="" required><br><br>

                <label>Last Name</label>
                <input type="text" name="last_name" value="" required><br><br>

                <label>Email</label>
                <input type="text" name="email" value="" required><br><br>

                <label>Password</label>
                <input type="password" name="password" value="" required><br><br>

                <label>Confirm Password</label>
                <input type="password" name="confirm_password" value="" required><br><br>

                <input type="submit" class="btn btn-primary" value="Register">
                <input type="reset" class="btn btn-default" value="Reset">
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form> 
</body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email_unique_error="";
    $confirm_password_err="";

    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $param_email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    //$param_password = password_hash($password, PASSWORD_DEFAULT);
    $confirm_password = trim($_POST["confirm_password"]);
    
    $conn = mysqli_connect("localhost", "root","","ewd_final_project");
    $sql = "SELECT first_name FROM users WHERE email = '$param_email';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck == 1){
        echo "Email ID is already in use..";
        $email_unique_error = '1';
    }

    $conn-> close();

    if(($password != $confirm_password)){
        $confirm_password_err = "1";
        echo "Passwords donot match..";
    }

    if($email_unique_error!='1' && $confirm_password_err!='1'){
        $conn = mysqli_connect("localhost", "root","","ewd_final_project");
        $sql2 = "INSERT INTO users (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$param_email', '$password');";
        mysqli_query($conn, $sql2);

        $profile_words = array("male", "female", "older", "younger","years","data","dead","not","higher","lesser","iss","heatmap");

        foreach ($profile_words as $word){
            $sqlx = "INSERT INTO user_profiles(email, word, count, average)values('$param_email', '$word', 0, 0.0);";
            mysqli_query($conn, $sqlx);
        }

        $conn-> close();
        echo "Registered Successfully!!";
    }

}
?>