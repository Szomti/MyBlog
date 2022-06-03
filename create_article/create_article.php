<?php
    session_start();
    $_SESSION['path'] = $_SERVER['REQUEST_URI'];
    if(!isset($_SESSION['theme'])){
        $_SESSION['theme'] = "dark";
    }
    $host = "localhost";
    $user = "root";
    $dbpassword = "";
    $database = "my_blog";
    $conn = mysqli_connect($host, $user, $dbpassword, $database);
    $edit = false;
    if(isset($_GET['articleId'])){
        $articleId = $_GET['articleId'];
        $sql = "SELECT * FROM `articles` WHERE `article_id`=".$articleId." AND `user_id`=".$_SESSION['user_id'];
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query)>0){
            $edit = true;
        }else{
            $edit = false;
            header("Location: ../create_article/create_article.php", true, 303);
        }
    }
    if(isset($_GET['creationFailed'])){
        if($_GET['creationFailed']=="true"){
            if(isset($_GET['articleId'])){
                echo "<script>alert('Edit failed!')</script>";
            }else{
                echo "<script>alert('Creation failed!')</script>";
            }
        }
    }
?>
<script>
    const titleMaxLength = "75";
    const contentMaxLength = "15000";
</script>

<!DOCTYPE html>
<html>
    <head>
        <title>Create Article</title>
        <meta charset="UTF-8">
        <?php
            if($_SESSION['theme']=="dark"){
                echo "<link rel='stylesheet' href='./create_article_dark.css'>";
            }else{
                echo "<link rel='stylesheet' href='./create_article_light.css'>";
            }
        ?>
        <link rel="icon" href="../icons/blog.png">
    </head>
    <body>
    <div class="top_bar">
            <div id="top_bar_left">
                <a href="../homepage/homepage.php" class="top_bar_element_left">Homepage</a>
                <?php
                    if(isset($_SESSION['user_id'])){
                        echo "<a href='../create_article/create_article.php' class='top_bar_element_left current_page'>Create Article</a>";
                        echo "<a href='../favourites/favourites.php' class='top_bar_element_left'>Favourites</a>";
                    }
                ?>
            </div>
            <div id="top_bar_right">
                <?php
                    if($_SESSION['theme']=="dark"){
                        echo "<a href='../theme/theme_change.php' class='top_bar_element_right'><img src='../icons/light.png' class='top_bar_element_right'></a>";
                    }else{
                        echo "<a href='../theme/theme_change.php' class='top_bar_element_right'><img src='../icons/dark.png' class='top_bar_element_right'></a>";
                    }
                    if(isset($_SESSION['user_id'])){
                        echo "<a href='../profile/logout.php?logout=true' class='top_bar_element_right'>Logout</a>";
                        echo "<label class='top_bar_element_right'>|</label>";
                        echo "<a href='../profile/profile.php' class='top_bar_element_right'>".$_SESSION['username']."</a>";
                    }else{
                        echo "<a href='../sign_in/sign_in.php' class='top_bar_element_right'>Sign In</a>";
                        echo "<a href='../sign_up/sign_up.php' class='top_bar_element_right'>Sign Up</a>";
                    }
                ?>
            </div>
        </div>
        <div class="empty_div">&nbsp;</div>
        <div class="main_div">
                <?php
                    echo "<div>&nbsp;</div>";
                    if($edit){
                        while($row = mysqli_fetch_assoc($query)){
                            echo "<form action='./handle_edit_article.php?articleId=".$articleId."' method='POST'>";
                            echo "<div class='article_context_text'>Title:</div>";
                            echo "<div class='article_count'><label id='titleCount'></label></div><br>";
                            echo "<input type='text' name='title' id='title' value='".$row['title']."' required>";
                            echo "<div class='article_context_text'>Content:</div>";
                            echo "<div class='article_count'><label id='contentCount'></label></div><br>";
                            echo "<textarea name='content' id='content' required>".$row['content']."</textarea><br>";
                        }
                    }else{
                        echo "<form action='./handle_create_article.php' method='POST'>";
                        echo "<div class='article_context_text'>Title:</div>";
                        echo "<div class='article_count'><label id='titleCount'></label></div><br>";
                        echo "<input type='text' name='title' id='title' required>";
                        echo "<div class='article_context_text'>Content:</div>";
                        echo "<div class='article_count'><label id='contentCount'></label></div><br>";
                        echo "<textarea name='content' id='content' required></textarea><br>";
                    }
                ?>
                <input type="submit" name="submit" class="submit_btn" value="Save">
            </form>
        </div>
        <div class="empty_div">&nbsp;</div>
    </body>
    <script>
        const titleArea = document.getElementById('title');
        const titleCounter = document.getElementById('titleCount');

        titleArea.maxLength = titleMaxLength;
        titleCounter.innerHTML = titleArea.value.length+"/"+titleMaxLength;

        titleArea.addEventListener("input", function(){
            var text = titleArea.value;
            titleCounter.innerHTML = text.length+"/"+titleMaxLength;
        });

        const contentArea = document.getElementById('content');
        const contentCounter = document.getElementById('contentCount');

        contentArea.maxLength = contentMaxLength;
        contentCounter.innerHTML = contentArea.value.length+"/"+contentMaxLength;

        contentArea.addEventListener("input", function(){
            var text = contentArea.value;
            contentCounter.innerHTML = text.length+"/"+contentMaxLength;
        });
    </script>
</html>

<?php
    mysqli_close($conn);
?>