<!DOCTYPE html>
<html>
<head>
    <title>Table with Favorite Colors</title>
</head>
<body>
<h3><a href="home.php">HOME</a></h3><br>
<?php
        session_start();
        if (!(isset($_SESSION["id"]))){
            //header("location: login.php");
            echo '<script>alert("Login to proceed..."); location="login.php"; </script>';
            
        }
?>
<?php

$search = $_SESSION['search_get'];


if($_SESSION['search_get'] == false){
    $gender = $_GET['gender'];
    $division = $_GET['division'];
    $action = $_GET['action'];
} else {
    $content_id = $_GET['content_id'];

    //echo "<br>content id= ".$content_id;
    $sql_search = "SELECT gender,none,age_gte_60,survived,iss_gte_25,heatmap from search_table where id='$content_id';";
    $conn = mysqli_connect("localhost", "root","","ewd_final_project");
    $result = mysqli_query($conn, $sql_search);
    $resultCheck = mysqli_num_rows($result);

    //echo "<br> result count = ".$resultCheck;

    if ($resultCheck > 0){
        while ($row = mysqli_fetch_assoc($result)){
            if ($row["gender"] == 'M'){
                $gender='male';
            } else {
                $gender='female';
            }
            $none = $row["none"];
            $age_gte_60 = $row["age_gte_60"];
            $survived = $row["survived"];
            $iss_gte_25 = $row["iss_gte_25"];
            $heatmap= $row["heatmap"];
        }
    }

    if($heatmap == 'N'){
        $action = 'data';
    } else {
        $action = 'image';
    }

    if($none=='Y'){
        $division = 'none';
    }

    if($age_gte_60 == 'Y' || $age_gte_60 == 'N'){
        $division = 'age';
    }

    if($survived == 'Y' || $survived == 'N'){
        $division = 'PatientOutcome';
    }

    if($iss_gte_25 == 'Y' || $iss_gte_25 == 'N'){
        $division = 'ISS';
    }

    $conn-> close();
}



if($division =='none'){
    $category = 'were admitted as trauma patients';
    if ($gender == 'male'){
        $sql = 'select * from trauma_patients_cytokines where gender="M";';
        $sql2 = 'select * from cytokine_heapmaps where gender="M" and none="Y";';
        $search_table_sql = 'select id,heatmap from search_table where gender="M" and none="Y";';
        $content_name = 'All Male Patients Cytokine Data';
    } else {
        $sql = 'select * from trauma_patients_cytokines where gender="F";';
        $sql2 = 'select * from cytokine_heapmaps where gender="F" and none="Y";';
        $search_table_sql = 'select id,heatmap from search_table where gender="F" and none="Y";';
        $content_name = 'All Female Patients Cytokine Data';
    }
}

if($division=='age'){

    if($_SESSION['search_get'] == false){
        $age = $_GET['age'];
    } else {
        if($age_gte_60 == 'Y'){
            $age = 'old';
        } else {
            $age = 'young'; 
        }
    }


    if($age == 'old'){
        $category = 'are 60 years and older';

        if ($gender == 'male'){
            $sql = 'select * from trauma_patients_cytokines where gender="M" and age_gte_60="Y";';
            $sql2 = 'select * from cytokine_heapmaps where gender="M" and age_gte_60="Y";';
            $search_table_sql = 'select id,heatmap from search_table where gender="M" and age_gte_60="Y";';
            $content_name = 'Male Patients Older than 60 years Cytokine Data';
        } else {
            $sql = 'select * from trauma_patients_cytokines where gender="F" and age_gte_60="Y";';
            $sql2 = 'select * from cytokine_heapmaps where gender="F" and age_gte_60="Y";';
            $search_table_sql = 'select id,heatmap from search_table where gender="F" and age_gte_60="Y";';
            $content_name = 'Female Patients Older than 60 years Cytokine Data';
        }
    } else {
        $category = 'are under 60 years age';

        if ($gender == 'male'){
            $sql = 'select * from trauma_patients_cytokines where gender="M" and age_gte_60="N";';
            $sql2 = 'select * from cytokine_heapmaps where gender="M" and age_gte_60="N";';
            $search_table_sql = 'select id,heatmap from search_table where gender="M" and age_gte_60="N";';
            $content_name = 'Male Patients Younger than 60 years Cytokine Data';
        } else {
            $sql = 'select * from trauma_patients_cytokines where gender="F" and age_gte_60="N";';
            $sql2 = 'select * from cytokine_heapmaps where gender="F" and age_gte_60="N";';
            $search_table_sql = 'select id,heatmap from search_table where gender="F" and age_gte_60="N";';
            $content_name = 'Female Patients Younger than 60 years Cytokine Data';
        }
        
    }
}

if($division=='PatientOutcome'){

    if($_SESSION['search_get'] == false){
        $outcome = $_GET['outcome'];
    } else {
        if($survived == 'Y'){
            $outcome = 'survive';
        } else {
            $outcome = 'dead';
        }

    }

    if($outcome == 'survive'){
        $category = 'survived';
        if ($gender == 'male'){
            $sql = 'select * from trauma_patients_cytokines where gender="M" and outcome="survived";';
            $sql2 = 'select * from cytokine_heapmaps where gender="M" and survived="Y";';
            $search_table_sql = 'select id,heatmap from search_table where gender="M" and survived="Y";';
            $content_name = 'Survived Male Patients Cytokine Data';
        } else {
            $sql = 'select * from trauma_patients_cytokines where gender="F" and outcome="survived";';
            $sql2 = 'select * from cytokine_heapmaps where gender="F" and survived="Y";';
            $search_table_sql = 'select id,heatmap from search_table where gender="F" and survived="Y";';
            $content_name = 'Survived Female Patients Cytokine Data';
        }
    } else {
        $category = 'did not survive';
        if ($gender == 'male'){
            $sql = 'select * from trauma_patients_cytokines where gender="M" and outcome="dead";';
            $sql2 = 'select * from cytokine_heapmaps where gender="M" and survived="N";';
            $search_table_sql = 'select id,heatmap from search_table where gender="M" and survived="N";';
            $content_name = 'Non-Survived Male Patients Cytokine Data';
        } else {
            $sql = 'select * from trauma_patients_cytokines where gender="F" and outcome="dead";';
            $sql2 = 'select * from cytokine_heapmaps where gender="F" and survived="N";';
            $search_table_sql = 'select id,heatmap from search_table where gender="F" and survived="N";';
            $content_name = 'Non-Survived Female Patients Cytokine Data';
        }
    }
}

if($division=='ISS'){

    if($_SESSION['search_get'] == false){
        $iss = $_GET['iss'];
    } else {
        if($iss_gte_25 == 'Y'){
            $iss = 'high';
        } else {
            $iss = 'low';
        }

    }

    if($iss == 'high'){
        $category = 'were admitted with ISS 25 and higher';
        if ($gender == 'male'){
            $sql = 'select * from trauma_patients_cytokines where gender="M" and iss_gte_25="Y";';
            $sql2 = 'select * from cytokine_heapmaps where gender="M" and iss_gte_25="Y";';
            $search_table_sql = 'select id,heatmap from search_table where gender="M" and iss_gte_25="Y";';
            $content_name = 'Male Patients greater than 25 ISS Cytokine Data';
        } else {
            $sql = 'select * from trauma_patients_cytokines where gender="F" and iss_gte_25="Y";';
            $sql2 = 'select * from cytokine_heapmaps where gender="F" and iss_gte_25="Y";';
            $search_table_sql = 'select id,heatmap from search_table where gender="F" and iss_gte_25="Y";';
            $content_name = 'Female Patients greater than 25 ISS Cytokine Data';
        }

    } else {
        $category = 'were admitted with ISS under 25';
        if ($gender == 'male'){
            $sql = 'select * from trauma_patients_cytokines where gender="M" and iss_gte_25="N";';
            $sql2 = 'select * from cytokine_heapmaps where gender="M" and iss_gte_25="N";';
            $search_table_sql = 'select id,heatmap from search_table where gender="M" and iss_gte_25="N";';
            $content_name = 'Male Patients less than 25 ISS Cytokine Data';
        } else {
            $sql = 'select * from trauma_patients_cytokines where gender="F" and iss_gte_25="N";';
            $sql2 = 'select * from cytokine_heapmaps where gender="F" and iss_gte_25="N";';
            $search_table_sql = 'select id,heatmap from search_table where gender="F" and iss_gte_25="N";';
            $content_name = 'Female Patients less than 25 ISS Cytokine Data';
        }
    }
}

//echo '<h3>This is for '.$gender.' patients who '.$category.'</h3>';

//echo $search_table_sql;

$conn = mysqli_connect("localhost", "root","","ewd_final_project");
$result = mysqli_query($conn, $search_table_sql);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0){
    while ($row = mysqli_fetch_assoc($result)){
        if($action=='data' && $row['heatmap']=='N'){
            $cont_id = $row["id"];
        } 
        
        if($action=='image' && $row['heatmap']=='Y'){
            $cont_id = $row["id"];
        } 
    }
}

$conn-> close();

//echo "Cont id from query = ".$cont_id;


// Handling favourites
$user_id = $_SESSION["id"];

$favourite_sql = 'select * from favourites where email="'.$user_id.'" and content_id='.$cont_id.';';
$conn = mysqli_connect("localhost", "root","","ewd_final_project");
$result = mysqli_query($conn, $favourite_sql);
$resultCheck = mysqli_num_rows($result);
if ($resultCheck > 0){
    if(isset($_GET['unfavourite'])){
        $favourite_delete_sql = 'delete from favourites where email="'.$user_id.'" and content_id='.$cont_id.';';
        mysqli_query($conn, $favourite_delete_sql);

        $favourites_count_sql = 'select count(*) as cnt from favourites where email="'.$user_id.'";';
        $result = mysqli_query($conn, $favourites_count_sql);
        $row = mysqli_fetch_assoc($result);
        $favourites_count = $row["cnt"];

        $profile_words = array("male", "female", "older", "younger","years","data","dead","not","higher","lesser","iss","heatmap");
        $cont_name_sql = 'select name from search_table where id='.$cont_id.';';
        $result = mysqli_query($conn, $cont_name_sql);
        $row = mysqli_fetch_assoc($result);
        $cont_name = $row["name"];

        $cont_name_lower = strtolower($cont_name);
        $cont_name_tokens = explode(" ", $cont_name_lower);
        foreach($profile_words as $word){
            if(in_array($word,$cont_name_tokens)){
                $count_increment_sql = 'update user_profiles set count=count-1 where email="'.$user_id.'" and word="'.$word.'";';
                mysqli_query($conn, $count_increment_sql);
            }
            $avg_sql = 'update user_profiles set average=count/'.$favourites_count.' where email="'.$user_id.'" and word="'.$word.'";';
            mysqli_query($conn, $avg_sql);
        }

        $all_contents = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,28,29);

        $delete_search_sort_sql = 'delete from user_search_sort where email="'.$user_id.'";';
        mysqli_query($conn, $delete_search_sort_sql);

        foreach($all_contents as $cid){
            $cont_name_sql = 'select name from search_table where id='.$cid.';';
            $result = mysqli_query($conn, $cont_name_sql);
            $row = mysqli_fetch_assoc($result);
            $cont_name = $row["name"];
    
            $cont_name_lower = strtolower($cont_name);
            $cont_name_tokens = explode(" ", $cont_name_lower);

            $relation_score = 0.0;

            foreach($cont_name_tokens as $token){
                if(in_array($token,$profile_words)){
                    $score_sql = 'select average from user_profiles where email="'.$user_id.'" and word="'.$token.'";';
                    $result = mysqli_query($conn, $score_sql);
                    $row = mysqli_fetch_assoc($result);
                    $score = $row["average"];
                    $relation_score = $relation_score + $score;
                }
            }

            $search_sort_sql = 'INSERT INTO user_search_sort(email, content_id,relation_score)values("'.$user_id.'",'.$cid.','.$relation_score.');';
            mysqli_query($conn, $search_sort_sql);
        }

    } else {
        $favourite='set';
    }
} else {
    if(isset($_GET['favourite'])){
        $favourite='set';
        $favourite_insert_sql = 'INSERT INTO favourites(email, content_id)VALUES("'.$user_id.'",'.$_GET['content_id'].');';
        mysqli_query($conn, $favourite_insert_sql);

        $favourites_count_sql = 'select count(*) as cnt from favourites where email="'.$user_id.'";';
        $result = mysqli_query($conn, $favourites_count_sql);
        $row = mysqli_fetch_assoc($result);
        $favourites_count = $row["cnt"];

        $profile_words = array("male", "female", "older", "younger","years","data","dead","not","higher","lesser","iss","heatmap");

        $cont_id = $_GET['content_id'];
        $cont_name_sql = 'select name from search_table where id='.$cont_id.';';
        $result = mysqli_query($conn, $cont_name_sql);
        $row = mysqli_fetch_assoc($result);
        $cont_name = $row["name"];

        $cont_name_lower = strtolower($cont_name);
        $cont_name_tokens = explode(" ", $cont_name_lower);

        foreach($profile_words as $word){
            if(in_array($word,$cont_name_tokens)){
                $count_increment_sql = 'update user_profiles set count=count+1 where email="'.$user_id.'" and word="'.$word.'";';
                mysqli_query($conn, $count_increment_sql);
            }

            $avg_sql = 'update user_profiles set average=count/'.$favourites_count.' where email="'.$user_id.'" and word="'.$word.'";';
            mysqli_query($conn, $avg_sql);
        }

        $all_contents = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,28,29);

        $delete_search_sort_sql = 'delete from user_search_sort where email="'.$user_id.'";';
        mysqli_query($conn, $delete_search_sort_sql);

        foreach($all_contents as $cid){
            $cont_name_sql = 'select name from search_table where id='.$cid.';';
            $result = mysqli_query($conn, $cont_name_sql);
            $row = mysqli_fetch_assoc($result);
            $cont_name = $row["name"];
    
            $cont_name_lower = strtolower($cont_name);
            $cont_name_tokens = explode(" ", $cont_name_lower);

            $relation_score = 0.0;

            foreach($cont_name_tokens as $token){
                if(in_array($token,$profile_words)){
                    $score_sql = 'select average from user_profiles where email="'.$user_id.'" and word="'.$token.'";';
                    $result = mysqli_query($conn, $score_sql);
                    $row = mysqli_fetch_assoc($result);
                    $score = $row["average"];
                    $relation_score = $relation_score + $score;
                }
            }

            $search_sort_sql = 'INSERT INTO user_search_sort(email, content_id,relation_score)values("'.$user_id.'",'.$cid.','.$relation_score.');';
            mysqli_query($conn, $search_sort_sql);
        }


    }
}
$conn->close();


if(!isset($favourite)){
if($division=='none'){
    echo '<a href="query.php?favourite=set&content_id='.$cont_id.'&division='.$division.'&gender='.$gender.'&action='.$action.'">Add to Favourites</a>';
}

if($division=='age'){
    echo '<a href="query.php?favourite=set&content_id='.$cont_id.'&division='.$division.'&gender='.$gender.'&age='.$age.'&action='.$action.'">Add to Favourites</a>';
}

if($division=='PatientOutcome'){
    echo '<a href="query.php?favourite=set&content_id='.$cont_id.'&division='.$division.'&gender='.$gender.'&outcome='.$outcome.'&action='.$action.'">Add to Favourites</a>';
}

if($division=='ISS'){
    echo '<a href="query.php?favourite=set&content_id='.$cont_id.'&division='.$division.'&gender='.$gender.'&iss='.$iss.'&action='.$action.'">Add to Favourites</a>';
}
}


if(isset($favourite)){
    if($division=='none'){
        echo '<a href="query.php?unfavourite=set&content_id='.$cont_id.'&division='.$division.'&gender='.$gender.'&action='.$action.'">Remove from Favourites</a>';
    }
    
    if($division=='age'){
        echo '<a href="query.php?unfavourite=set&content_id='.$cont_id.'&division='.$division.'&gender='.$gender.'&age='.$age.'&action='.$action.'">Remove from Favourites</a>';
    }
    
    if($division=='PatientOutcome'){
        echo '<a href="query.php?unfavourite=set&content_id='.$cont_id.'&division='.$division.'&gender='.$gender.'&outcome='.$outcome.'&action='.$action.'">Remove from Favourites</a>';
    }
    
    if($division=='ISS'){
        echo '<a href="query.php?unfavourite=set&content_id='.$cont_id.'&division='.$division.'&gender='.$gender.'&iss='.$iss.'&action='.$action.'">Remove from Favourites</a>';
    }
}

// end of favourites

echo '<h3>This is for '.$gender.' patients who '.$category.'</h3>';

if ($action=='data'){
$conn = mysqli_connect("localhost", "root","","ewd_final_project");
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);
?>

<table>
    <tr>
        <th>GM_CSF</th>
        <th>IL_10</th>
        <th>IL_17A</th>
        <th>IL_1B</th>
        <th>IL_2</th>
        <th>IL_4</th>
        <th>IL_5</th>
        <th>IL_6</th>
        <th>IL_7</th>
        <th>IL_8</th>
        <th>IP_10</th>
        <th>MCP_1</th>
        <th>TNFA</th>
        <th>IL_22</th>
        <th>IL_9</th>
        <th>IL_33</th>
        <th>IL_21</th>
        <th>IL_23</th>
        <th>IL_17E</th>
        <th>IL_27</th>
        <th>MIG</th>
    </tr>
<?php
if ($resultCheck > 0){
    while ($row = mysqli_fetch_assoc($result)){
        echo "<tr><td>". $row["gm_csf"] ."</td><td>". $row["il_10"] ."</td><td>".$row["il_17a"] ."</td><td>".$row["il_1b"] ."</td><td>".$row["il_2"] ."</td><td>".$row["il_4"] ."</td><td>".$row["il_5"] ."</td><td>".$row["il_6"] ."</td><td>".$row["il_7"] ."</td><td>".$row["il_8"] ."</td><td>".$row["ip_10"] ."</td><td>".$row["mcp_1"] ."</td><td>".$row["tnfa"] ."</td><td>".$row["il_22"] ."</td><td>".$row["il_9"] ."</td><td>".$row["il_33"] ."</td><td>".$row["il_21"] ."</td><td>".$row["il_23"] ."</td><td>".$row["il_17e"] ."</td><td>".$row["il_27"] ."</td><td>".$row["mig"] ."</td></tr>";
    }
    echo "</table>";
}
else {
    echo "0 result";
}

$fn = $_SESSION["username"];
$ln = $_SESSION["last_name"];
$ut = $_SESSION["user_type"];
$eml = $_SESSION["id"];
$sql2 = "INSERT INTO USER_ACTIONS(first_name, last_name, email, user_type, action)values('$fn','$ln','$eml','$ut','get');";
$sql3 = "INSERT INTO content_access(email,content)values('$eml','$content_name');";
mysqli_query($conn, $sql2);
mysqli_query($conn, $sql3);

$conn-> close();
} else {
    $conn = mysqli_connect("localhost", "root","","ewd_final_project");
    $result = mysqli_query($conn, $sql2);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0){
        while ($row = mysqli_fetch_assoc($result)){
            echo  '<img src="data:image;base64, '.base64_encode($row['heatmap']).'" alt="Image" >';
        }
    }
    else {
        echo "0 result";
    }

    $fn = $_SESSION["username"];
    $ln = $_SESSION["last_name"];
    $ut = $_SESSION["user_type"];
    $eml = $_SESSION["id"];
    $sql2 = "INSERT INTO USER_ACTIONS(first_name, last_name, email, user_type, action)values('$fn','$ln','$eml','$ut','get');";
    $y = $content_name.' Heatmap';
    $sql3 = "INSERT INTO content_access(email,content)values('$eml','$y');";
    mysqli_query($conn, $sql2);
    mysqli_query($conn, $sql3);

    $conn-> close();
}


?>
</table>
</body>
</html>