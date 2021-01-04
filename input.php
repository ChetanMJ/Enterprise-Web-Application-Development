<html>
<body>
<h2> Input Cytokines data for Trauma Patients</h2>

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
    <form action="logout.php" method="get">
        <?php
            if (isset($_SESSION["id"])){
                echo '<h4>USER :'.$_SESSION["username"].'<h4>';
                echo '<input type="submit" name="logout" value="LOGOUT">';
            }
        ?>
    </form>

<h3><a href="home.php">HOME</a></h3><br>
<form action="processing.php" method="get">
<b>Gender:</b>
<input type="radio" id="male" name="gender" value="M" required>
<label for="male">Male</label>
<input type="radio" id="female" name="gender" value="F" required>
<label for="female">Female</label><br><br>

<b>Age:</b>
<input type="radio" id="Y" name="age" value="Y" required>
<label for="Y">60 and Older</label>
<input type="radio" id="N" name="age" value="N" required>
<label for="N">Under 60</label><br><br>

<b>PatientOutcome:</b>
<input type="radio" id="survived" name="outcome" value="survived" required>
<label for="survived">Survived</label>
<input type="radio" id="dead" name="outcome" value="dead" required>
<label for="dead">Not Survived</label><br><br>

<b>ISS:</b>
<input type="radio" id="Y" name="iss" value="Y" required>
<label for="Y">25 and greater</label>
<input type="radio" id="N" name="iss" value="N" required>
<label for="N">under 25</label><br><br>

<h3>Cytokine values</h3>
<b>GM_CSF:</b><input type="text" name="gm_csf" value=""><br><br>
<b>IL_10:</b><input type="text" name="il_10" value=""><br><br>
<b>IL_17A:</b><input type="text" name="il_17a" value=""><br><br>
<b>MIG:</b><input type="text" name="mig" value=""><br><br>
<input type="submit" name="insert" value="Insert">
</form>
</body>
</html>
