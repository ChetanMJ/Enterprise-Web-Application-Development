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
<form action="" method="post">
    <input type="text" name="search" value="Search..">
    <input type="submit" name="search_button" value="Search"><br>
</form>
<?php
if(!(isset($_POST['search']))){
    echo "<b>Submit Search Criteria...</b>";
} else {
$full_token = $_POST['search'];

//remove common words
$stopWords = ['/ the/','/ this/','/ then/','/ there/','/ how/','/ when/','/ where/','/ to/',
'/the /','/this /','/then /','/there /','/how /','/when /','/where /','/is /','/to /','/ get/','/ find/','/get /','/find /',
'/\?/','/\./','/\#/','/\"/','/\,/','/\-/','/\'/'];

$full_token_lower = strtolower($full_token);
$words = preg_replace($stopWords,' ',$full_token_lower);

$tokens = explode(" ", $words);

$sql='';
$i=0;

if (isset($_SESSION["id"])){
    $email = $_SESSION["id"];
} else {
    $email = 'NA';
}


foreach ($tokens as &$value) {
    $i=$i + 1;
    $token = strtolower($value);
    $sql1 = 'Select id, name, description, relation_score from search_table a join user_search_sort b on a.id=b.content_id  where lower(name)="'.$token.'" and b.email="'.$email.'" UNION ';
    $sql2 = 'Select id, name, description, relation_score from search_table a join user_search_sort b on a.id=b.content_id where lower(name) like "'.$token.'%" and b.email="'.$email.'" UNION ';
    $sql3 = 'Select id, name, description, relation_score from search_table a join user_search_sort b on a.id=b.content_id where lower(name) like "% '.$token.'%" and b.email="'.$email.'" UNION ';
    $sql4 = 'Select id, name, description, relation_score from search_table a join user_search_sort b on a.id=b.content_id where lower(description) like "% '.$token.'%" and b.email="'.$email.'" UNION ';
    $sql5 = 'Select id, name, description, relation_score from search_table a join user_search_sort b on a.id=b.content_id where lower(associated_search_words) like "% '.$token.'%" and b.email="'.$email.'"';
    if ( $i==1){
        $sql = '('.$sql1.$sql2.$sql3.$sql4.$sql5.')';
    } else {
        $sql = $sql.' INTERSECT '.'('.$sql1.$sql2.$sql3.$sql4.$sql5.')';
    }
}


if ($i > 1){
    $j = 0;
    $sql = '('.$sql.') UNION';
    foreach ($tokens as &$value) {
        $j=$j + 1;
        $token = strtolower($value);
        $sql1 = 'Select id, name, description, relation_score from search_table a join user_search_sort b on a.id=b.content_id where lower(name)="'.$token.'" and b.email="'.$email.'" UNION ';
        $sql2 = 'Select id, name, description, relation_score from search_table a join user_search_sort b on a.id=b.content_id where lower(name) like "'.$token.'%" and b.email="'.$email.'" UNION ';
        $sql3 = 'Select id, name, description, relation_score from search_table a join user_search_sort b on a.id=b.content_id where lower(name) like "% '.$token.'%" and b.email="'.$email.'" UNION ';
        $sql4 = 'Select id, name, description, relation_score from search_table a join user_search_sort b on a.id=b.content_id where lower(description) like "% '.$token.'%" and b.email="'.$email.'" UNION ';
        $sql5 = 'Select id, name, description, relation_score from search_table a join user_search_sort b on a.id=b.content_id where lower(associated_search_words) like "% '.$token.'%" and b.email="'.$email.'"';
        if ( $j==1){
            $sql = $sql.'('.$sql1.$sql2.$sql3.$sql4.$sql5.')';
        } else {
            $sql = $sql.' UNION '.'('.$sql1.$sql2.$sql3.$sql4.$sql5.')';
        }
    }
}

$sql='Select id, name, description from ('.$sql.' ) x order by relation_score desc;';
//echo $sql;
echo "<br>";
$_SESSION['search_get'] = true;
$conn = mysqli_connect("localhost", "root","","ewd_final_project");
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
echo '<h1>Search results for "'.$full_token.'"... '.$resultCheck.' rows found </h1>';
if ($resultCheck > 0){
    while ($row = mysqli_fetch_assoc($result)){
        if($row["id"]==30){
            echo '<h3><a href="input.php">'. $row["name"] ."</a></h3><p>". $row["description"] ."</p><br>";
        } else {
            $content_id = $row["id"];
            //echo "<br> content id = ".$content_id;
            echo '<h3><a href="query.php?content_id='.urlencode($content_id).'">'. $row["name"] .'</a></h3><p>'. $row["description"] .'</p><br>';
        }
    }
}
else {
    //echo "0 result";
    $sqlx = "INSERT INTO zero_result_search(search_token)values('$full_token');";
    mysqli_query($conn, $sqlx);
}

$conn-> close();
}
?>

