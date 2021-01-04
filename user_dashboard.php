<!DOCTYPE html>
<html>
<head>
    <title>Table with Favorite Colors</title>
</head>
<body>

<?php
        session_start();
        if (!(isset($_SESSION["id"]))){
            //header("location: login.php");
            echo '<script>alert("Login to proceed..."); location="login.php"; </script>';
            
        } else {
            echo '<h4>USER :'.$_SESSION["username"].'<h4>';
        }
?>
<h3><a href="home.php">HOME</a></h3><br>
<h2>Dashboard<h2>


<h3>Login Count</h3>
<table>
    <tr>
        <th>Total_Logins</th>
    </tr>
    <?php
    $user_id = $_SESSION["id"];

    $conn = mysqli_connect("localhost", "root","","ewd_final_project");
    $sql = "SELECT  count(*) as total_logins
    from user_actions where action='login' and email='".$user_id."';";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0){
        while ($row = mysqli_fetch_assoc($result)){
            echo "<tr><td>".$row["total_logins"]."</td></tr>";
        }
        echo "</table><br>";
    }

    $conn-> close();
?>

<h3>Action Count</h3>
<table>
    <tr>
        <th>First_Name</th>
        <th>Last_Name</th>
        <th>Email</th>
        <th>Data_Inserts</th>
        <th>Data_Accesses</th>
        <th>Total_Actions</th>
    </tr>
    <?php
    $user_id = $_SESSION["id"];
    $conn = mysqli_connect("localhost", "root","","ewd_final_project");
    $sql = "SELECT
    First_name,last_name,email,
    sum(case when action='insert' then 1 else 0 end) as insert_counts,
    sum(case when action='get' then 1 else 0 end) as get_counts,
    count(*) as total_actions
    from user_actions where  action in ('insert','get') and email='".$user_id."'
    group by First_name,last_name,email
    order by total_actions desc;";

    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0){
        $i=0;
        while ($row = mysqli_fetch_assoc($result)){
            $i = $i + 1;
            echo "<tr><td>". $row["First_name"] ."</td><td>". $row["last_name"] ."</td><td>".$row["email"]."</td><td>".$row["insert_counts"]."</td><td>".$row["get_counts"]."</td><td>".$row["total_actions"]."</td></tr>";
            if ($i == 5){
            break;
            }
        }
        echo "</table><br>";
    }

    $conn-> close();
?>

<h3>Top 5 Contents</h3>
<table>
    <tr>
        <th>Content</th>
        <th>Access_Count</th>
    </tr>
    <?php
    $user_id = $_SESSION["id"];
    $conn = mysqli_connect("localhost", "root","","ewd_final_project");
    $sql = "SELECT
    content,count(distinct email) as access_count
    from content_access  where email='".$user_id."'
    group by content
    order by access_count desc;";

    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0){
        $i=0;
        while ($row = mysqli_fetch_assoc($result)){
            $i = $i + 1;
            echo "<tr><td>". $row["content"] ."</td><td>". $row["access_count"]."</td></tr>";
            if ($i == 5){
            break;
            }
        }
        echo "</table><br>";
    }

    $conn-> close();
?>
