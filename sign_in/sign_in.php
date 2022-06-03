<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        header("Location: ../profile/profile.php", true, 301);
    }
    $host = "localhost";
    $user = "root";
    $dbpassword = "";
    $database = "my_blog";
    $conn = mysqli_connect($host, $user, $dbpassword, $database);
    if(isset($_GET['firstTime'])){
        $firstTime = $_GET['firstTime'];
        if($firstTime=="true"){
            echo "<script>alert('User Signed-Up Correctly!')</script>";
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Sign In</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./sign_in.css">
        <link rel="icon" href="../icons/blog.png">
    </head>
    <body>
        <div class="top_bar">
            <div id="top_bar_left">
                <a href="../homepage/homepage.php" class="top_bar_element_left">Homepage</a>
            </div>
            <div id="top_bar_right">
                <?php
                    if(isset($_SESSION['user_id'])){
                        echo "<a href='../profile/profile.php' class='top_bar_element_right'>".$_SESSION['username']."</a>";
                    }else{
                        echo "<a href='../sign_in/sign_in.php' class='top_bar_element_right'>Sign In</a>";
                        echo "<a href='../sign_up/sign_up.php' class='top_bar_element_right'>Sign Up</a>";
                    }
                ?>
            </div>
        </div>
        <div class="empty_div">&nbsp;</div>
            <div id="flex_div">
                <div class="main_div">
                    <h2>Sign In</h2>
                    <form action="sign_in.php" method="POST">
                        <input type="text" name="username" placeholder="Username" class="sign_up_input" required><br>
                        <input type="password" name="password" placeholder="Password" class="sign_up_input" required><br>
                        <input type="submit" name="submit" class="submit_btn" value="Confirm">
                    </form>
                    <?php
                        if(isset($_POST['submit'])){
                            $username = $_POST['username'];
                            $password = $_POST['password'];

                            $sql = "SELECT * FROM `users` WHERE `name`='".$username."';";
                            $query = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_assoc($query)){
                                if($row['name']==$username){
                                    if(password_verify($password, $row['password'])){
                                        $_SESSION['user_id'] = $row['user_id'];
                                        $_SESSION['username'] = $username;
                                        header("Location: ../profile/profile.php", true, 301);
                                    }
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        <div class="empty_div">&nbsp;</div>
    </body>
</html>

<?php
    mysqli_close($conn);
?>