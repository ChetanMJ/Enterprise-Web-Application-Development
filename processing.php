<html>
<head>
<title></title>
</head>
<body>
<h3><a href="home.php">HOME</a></h3><br>
<?php
        session_start();
        if (!(isset($_SESSION["id"]))){
            //header("location: login.php");
            echo '<script>alert("Login to proceed..."); location="login.php"; </script>';
            
        } else {
            if ($_SESSION["user_type"]=='guest'){
                echo '<script>alert("Access Denied..."); location="home.php"; </script>';
            }
        }
?>
<?php
    $conn = mysqli_connect("localhost", "root","","ewd_final_project");
    $gender = $_GET['gender'];
    $age = $_GET['age'];
    $outcome = $_GET['outcome'];
    $iss = $_GET['iss'];
    $gm_csf = $_GET['gm_csf'];
    $il_10 = $_GET['il_10'];
    $il_17a = $_GET['il_17a'];
    $mig = $_GET['mig'];
    $sql = "INSERT INTO trauma_patients_cytokines(gender, age_gte_60, outcome, iss_gte_25, gm_csf, il_10, il_17a, mig) VALUES('$gender','$age','$outcome','$iss','$gm_csf','$il_10','$il_17a','$mig');";
    mysqli_query($conn, $sql);
    echo "Data Inserted Successfully for truma petient !!";

    $fn = $_SESSION["username"];
    $ln = $_SESSION["last_name"];
    $ut = $_SESSION["user_type"];
    $eml = $_SESSION["id"];
    $sql2 = "INSERT INTO USER_ACTIONS(first_name, last_name, email, user_type, action)values('$fn','$ln','$eml','$ut','insert');";
    mysqli_query($conn, $sql2);

    $conn-> close();

?>
</body>
</html>
