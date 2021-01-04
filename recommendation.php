<html>
<body>
<form action="logout.php" method="get">
        <?php
            session_start();
            if (isset($_SESSION["id"])){
                echo '<h4>USER :'.$_SESSION["username"].'<h4>';
                echo '<input type="submit" name="logout" value="LOGOUT">';
            }
        ?>
</form>
<h3><a href="home.php">HOME</a></h3><br>
<?php
echo '<h2>Recommendations<h1>';
if (!isset($_SESSION["id"])){
    $recom_sql = 'SELECT id, name, description, count(*) FROM favourites a join search_table b on a.content_id = b.id group by id, name, description order by count(*) desc;';
} else {
    $email=$_SESSION["id"];
    $recom_sql = 'SELECT id, name, description, count(*) FROM favourites a join search_table b on a.content_id = b.id where email in (select email from favourites where content_id in (select content_id from favourites where email="'.$email.'") )and content_id not in (select content_id from favourites where email="'.$email.'") group by id, name, description order by count(*) desc;';
}
$conn = mysqli_connect("localhost", "root","","ewd_final_project");
$result = mysqli_query($conn, $recom_sql);
$resultCheck = mysqli_num_rows($result);

if ($resultCheck == 0){
    $recom_sql = 'SELECT id, name, description, count(*) FROM favourites a join search_table b on a.content_id = b.id group by id, name, description order by count(*) desc;';
}

$result = mysqli_query($conn, $recom_sql);
$resultCheck = mysqli_num_rows($result);

if ($resultCheck > 0){
    $i = 0;
    $_SESSION['search_get'] = true;
    while ($row = mysqli_fetch_assoc($result)){
        $i = $i + 1;
        $content_id = $row["id"];
        //echo "<br> content id = ".$content_id;
        echo '<h3><a href="query.php?content_id='.urlencode($content_id).'">'. $row["name"] .'</a></h3><p>'. $row["description"] .'</p><br>';
        if ($i == 5){
        break;
        }
    }
} else {
    echo '<h3>None..<h3>';
}
$conn->close();
?>
