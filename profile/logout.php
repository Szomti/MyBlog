<?php
    session_start();
    $host = "localhost";
    $user = "root";
    $dbpassword = "";
    $database = "my_blog";
    $conn = mysqli_connect($host, $user, $dbpassword, $database);

    if(isset($_GET['logout'])){
        if($_GET['logout']=="true"){
            session_unset();
            session_destroy();
            header("Location: ../homepage/homepage.php", true, 303);
        }
    }

    mysqli_close($conn);
?>