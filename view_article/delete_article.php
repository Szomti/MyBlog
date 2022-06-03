<?php
    session_start();
    $host = "localhost";
    $user = "root";
    $dbpassword = "";
    $database = "my_blog";
    $conn = mysqli_connect($host, $user, $dbpassword, $database);
    
    if(isset($_POST['articleId'])){
        $articleId = $_POST['articleId'];
        $sql = "DELETE FROM `articles` WHERE `article_id`=".$articleId.";";
        $query= mysqli_query($conn, $sql);
        header("Location: ../profile/profile.php");
    }

    mysqli_close($conn);
?>