<html>
<body>
    <form action="login.php" method="get">
    <?php
        session_start();
        if (!(isset($_SESSION["id"]))){
        echo '<input type="submit" name="login" value="LOGIN">';
        }
        ?>
    </form>
    <form action="registration.php" method="get">
        <?php
        if (!(isset($_SESSION["id"]))){
            echo '<input type="submit" name="register" value="REGISTER">';
        }
        ?>
    </form>
    <form action="logout.php" method="get">
        <?php
            if (isset($_SESSION["id"])){
                echo '<h4>USER :'.$_SESSION["username"].'<h4>';
                echo '<input type="submit" name="logout" value="LOGOUT">';
            }
        ?>
    </form>
    <h1>Cytokines of Trauma Patients</h1>
    <h2>Introduction:<h2>
    <h3>Cytokines are small proteins secreted by immune system of a person. 
    Secretion pattern of these cytokines especially become important with trauma patients as it is used to determine their treatment process.
    This application provides the UI to manage and access this data.<h3>

    <h3><a href="search.php">Search Content</a></h3>
    <h3><a href="recommendation.php">Recommendations</a></h3>

    <?php
            if (isset($_SESSION["id"])){
                echo '<h3><a href="get.php">Get Cytokines Data and Correlation Heatmaps</a></h3>';

                if($_SESSION["user_type"] == 'moderator' || $_SESSION["user_type"] == 'admin' ){
                    echo '<h3><a href="input.php">Input Cytokines Data</a></h3>';
                }

                echo '<h3><a href="user_dashboard.php">User Dashboard</a></h3>';

                if($_SESSION["user_type"] == 'admin' ){
                    echo '<h3><a href="dashboard.php">Admin Dashboard</a></h3>';
                }



                //echo '<h3><a href="recommendation.php">Recommendations</a></h3>';

                if (isset($_SESSION["id"])){
                    $user_id=$_SESSION["id"];
                    echo '<h2>Favourites<h1>';

                    $favourite_sql = 'select email, content_id from favourites where email="'.$user_id.'";';
                    $conn = mysqli_connect("localhost", "root","","ewd_final_project");
                    $result = mysqli_query($conn, $favourite_sql);
                    $resultCheck = mysqli_num_rows($result);

                    if($resultCheck == 0){
                        echo "<h3>None..<h3>";
                    } else {
                        $_SESSION['search_get'] = true;
                        while ($row = mysqli_fetch_assoc($result)){
                            $cont_id = $row['content_id'];
                            $content_sql = 'Select id, name, description from search_table where id='.$cont_id.';';
                            $result2 = mysqli_query($conn, $content_sql);
                            $row2 = mysqli_fetch_assoc($result2);
                            echo '<h3><a href="query.php?content_id='.urlencode($cont_id).'">'. $row2["name"] .'</a></h3><p>'. $row2["description"] .'</p><br>';
                        }
                    }
                    $conn->close();
                }
            }
    ?>   
</body>
</html>
