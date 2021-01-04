<html>
<body>
<h2> Get the Cytokines data and Correlation Heatmaps</h2>

<?php
        session_start();
        if (!(isset($_SESSION["id"]))){
            //header("location: login.php");
            echo '<script>alert("Login to proceed..."); location="login.php"; </script>';
            
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

<form action="" method="post">
<b>Gender:</b>
<input type="radio" id="male" name="gender" value="male" <?php if(isset($_POST['gender']) && $_POST['gender'] =='male' ){echo "checked";}?> required>
<label for="male">Male</label>
<input type="radio" id="female" name="gender" value="female" <?php if(isset($_POST['gender']) && $_POST['gender'] =='female' ){echo "checked";}?> required>
<label for="female">Female</label><br><br>
<b>Divide Data on:</b>
<input type="radio" id="none" name="division" value="none" <?php if(isset($_POST['division']) && $_POST['division'] =='none' ){echo "checked";}?> required>
<label for="none">None</label>
<input type="radio" id="age" name="division" value="age" <?php if(isset($_POST['division']) && $_POST['division'] =='age' ){echo "checked";}?> required>
<label for="age">Age</label>
<input type="radio" id="PatientOutcome" name="division" value="PatientOutcome" <?php if(isset($_POST['division']) && $_POST['division'] =='PatientOutcome' ){echo "checked";}?> required>
<label for="PatientOutcome">Patient Outcome</label>
<input type="radio" id="ISS" name="division" value="ISS" <?php if(isset($_POST['division']) && $_POST['division'] =='ISS' ){echo "checked";}?> required>
<label for="ISS">ISS</label><br><br>
<input type="submit" name='proceed' value="Proceed">
</form>

<form action="query.php" method="get">

    <input type="hidden" name='gender' value=<?php if(isset($_POST['gender'])){echo $_POST['gender'];} else {echo "";}?> >
    <input type="hidden" name='division' value=<?php if(isset($_POST['division'])){echo $_POST['division'];} else {echo "";}?> >

    <?php
        $_SESSION['search_get'] = false;
        if(isset($_POST['proceed'])){
            if($_POST['division']=='age'){
                echo '<b>Age:</b> <input type="radio" id="old" name="age" value="old" required>';
                echo '<label for="old">60 and Older</label>';
                echo '<input type="radio" id="young" name="age" value="young" required>';
                echo '<label for="young">Under 60</label><br><br>';
            }

            if($_POST['division']=='PatientOutcome'){
                echo '<b>PatientOutcome:</b> <input type="radio" id="survive" name="outcome" value="survive" required>';
                echo '<label for="survive">Survived</label>';
                echo '<input type="radio" id="not survive" name="outcome" value="not survive" required>';
                echo '<label for="not survive">Not Survived</label><br><br>';
            }

            if($_POST['division']=='ISS'){
                echo '<b>ISS:</b> <input type="radio" id="high" name="iss" value="high" required>';
                echo '<label for="high">25 and greater</label>';
                echo '<input type="radio" id="low" name="iss" value="low" required>';
                echo '<label for="low">under 25</label><br><br>';
            }

            echo '<b>Action:</b> <input type="radio" id="data" name="action" value="data" required>';
            echo '<label for="data">Get Data</label>';
            echo '<input type="radio" id="image" name="action" value="image" required>';
            echo '<label for="image">Get Correlation Heatmap</label><br>';
            echo '<br><input type="submit" name="submit" value="Submit">';

        }
    ?>
</form>

</body>
</html>