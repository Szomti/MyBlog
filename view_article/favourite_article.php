<?php
    session_start();
    $host = "localhost";
    $user = "root";
    $dbpassword = "";
    $database = "my_blog";
    $conn = mysqli_connect($host, $user, $dbpassword, $database);

    if(isset($_GET['articleId'])){
        $articleId = $_GET['articleId'];
        $sql="SELECT * FROM `favourites` WHERE `user_id`=".$_SESSION['user_id']." AND `article_id`=".$articleId.";";
        $query= mysqli_query($conn, $sql);
        if(mysqli_num_rows($query)==0){
            $timestamp = date('Y-m-d H:i:s');
            $sql = "INSERT INTO `favourites`(`user_id`,`article_id`,`add_time`) VALUES (".$_SESSION['user_id'].",".$articleId.",'".$timestamp."');";
            $query= mysqli_query($conn, $sql);
        }else{
            $sql = "DELETE FROM `favourites` WHERE `user_id`=".$_SESSION['user_id']." AND `article_id`=".$articleId.";";
            $query= mysqli_query($conn, $sql);
        }
        #header("Location: ../view_article/view_article.php?articleId=".$articleId, true, 301);
        if(isset($_SESSION['path'])){
            header("Location: ".$_SESSION['path'], true, 301);
        }else{
            header("Location: ../homepage/homepage.php", true, 301);
        }
    }

    mysqli_close($conn);
?>