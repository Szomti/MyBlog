<?php
    session_start();

    if(isset($_SESSION['theme'])){
        switch($_SESSION['theme']){
            case "dark":
                $_SESSION['theme']="light";
                break;
            case "light":
                $_SESSION['theme']="dark";
                break;
        }
    }
    
    if(isset($_SESSION['path'])){
        header("Location: ".$_SESSION['path'], true, 301);
    }else{
        header("Location: ../profile/profile.php", true, 301);
    }
?>