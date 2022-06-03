<?php
    session_start();
    $host = "localhost";
    $user = "root";
    $dbpassword = "";
    $database = "my_blog";
    $conn = mysqli_connect($host, $user, $dbpassword, $database);
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        $_SESSION['tempUsername'] = $username;
        $sql = "SELECT * FROM `users` WHERE `name`='".$username."'";
        $query = mysqli_query($conn, $sql);
        if(mysqli_fetch_array($query)==null){
            $sql = "INSERT INTO `users`(`name`, `password`) VALUES ('".$username."','".password_hash($password, PASSWORD_BCRYPT)."');";
            $query = mysqli_query($conn, $sql);
            unset($_SESSION['tempUsername']);
            unset($_SESSION['tempPassword']);
            header("Location: ../sign_in/sign_in.php?firstTime=true", true, 301);
        }else{
            header("Location: ../sign_up/sign_up.php?usernameExists=true", true, 301);
        }
    }
    mysqli_close($conn);
?>