<?php
    session_start();
    $_SESSION['path'] = $_SERVER['REQUEST_URI'];
    if(isset($_SESSION['user_id'])){
        header("Location: ../profile/profile.php", true, 301);
    }
    if(!isset($_SESSION['theme'])){
        $_SESSION['theme'] = "dark";
    }
    $host = "localhost";
    $user = "root";
    $dbpassword = "";
    $database = "my_blog";
    $conn = mysqli_connect($host, $user, $dbpassword, $database);
?>
<script>
    function validateForm(){
        var valid = true;
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm_password').value;

        if(username.length<4){
            alert('Username is too short\n('+username.length+'/4 characters)');
            valid = false;
        }
        if(username.length>32){
            alert('Username is too long\n('+username.length+'/32 characters)');
            valid = false;
        }
        if(password.length<4){
            alert('Password is too short\n('+password.length+'/4 characters)');
            valid = false;
        }
        if(password.length>20){
            alert('Password is too long\n('+password.length+'/20 characters)');
            valid = false;
        }
        if(password!=confirmPassword){
            alert('Passwords aren\'t the same!');
            valid = false;
        } 

        return valid;
    }
</script>

<!DOCTYPE html>
<html>
    <html>
        <head>
            <title>Sign Up</title>
            <meta charset="UTF-8">
            <?php
                if($_SESSION['theme']=="dark"){
                    echo "<link rel='stylesheet' href='./sign_up_dark.css'>";
                }else{
                    echo "<link rel='stylesheet' href='./sign_up_light.css'>";
                }
            ?>
            <link rel="icon" href="../icons/blog.png">
        </head>
        <body>
            <div class="top_bar">
                <div id="top_bar_left">
                    <a href="../homepage/homepage.php" class="top_bar_element_left">Homepage</a>
                </div>
                <div id="top_bar_right">
                    <?php
                        if($_SESSION['theme']=="dark"){
                            echo "<a href='../theme/theme_change.php' class='top_bar_element_right'><img src='../icons/light.png' class='top_bar_element_right'></a>";
                        }else{
                            echo "<a href='../theme/theme_change.php' class='top_bar_element_right'><img src='../icons/dark.png' class='top_bar_element_right'></a>";
                        }
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
                    <form action="./handle_sign_up.php" onsubmit="return validateForm()" method="POST">
                        <h2>Sign Up</h2>
                        <input type="text" name="username" id="username" maxlength="32" placeholder="Username" class="sign_up_input" required 
                        <?php
                            if(isset($_SESSION['tempUsername'])){
                                echo "value='".$_SESSION['tempUsername']."'";
                            }
                        ?>><br>
                        <?php
                            if(isset($_GET['usernameExists'])){
                                if($_GET['usernameExists']=="true"){
                                    echo "<label class='error_text'>Username is taken!</label><br>";
                                }
                            }
                        ?>
                        <input type="password" name="password" id="password" maxlength="20" placeholder="Password" class="sign_up_input" required><br>
                        <input type="password" name="confirm_password" id="confirm_password" maxlength="20" placeholder="Password" class="sign_up_input" required><br>
                        <input type="submit" name="submit" class="submit_btn" value="Confirm">
                    </form>
                </div>
            </div>
            <div class="empty_div">&nbsp;</div>
        </body>
    </html>
</html>
<script>
    const signUpElems = document.getElementsByClassName('sign_up_input');

    for (var i = 0; i < signUpElems.length; i++) {
        signUpElems[i].addEventListener('keypress', function (event){
            var key = event.keyCode;
            if (key === 32) {
                event.preventDefault();
            }
        });
    }
</script>
<?php
    mysqli_close($conn);
?>