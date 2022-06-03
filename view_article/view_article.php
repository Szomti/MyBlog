<?php
    session_start();
    $_SESSION['path'] = $_SERVER['REQUEST_URI'];
    $host = "localhost";
    $user = "root";
    $dbpassword = "";
    $database = "my_blog";
    $conn = mysqli_connect($host, $user, $dbpassword, $database);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Article</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./view_article.css">
        <link rel="icon" href="../icons/blog.png">
    </head>
    <body>
        <div class="top_bar">
            <div id="top_bar_left">
                <a href="../homepage/homepage.php" class="top_bar_element_left">Homepage</a>
                <?php
                    if(isset($_SESSION['user_id'])){
                        echo "<a href='../create_article/create_article.php' class='top_bar_element_left'>Create Article</a>";
                        echo "<a href='../favourites/favourites.php' class='top_bar_element_left'>Favourites</a>";
                    }
                ?>
            </div>
            <div id="top_bar_right">
                <?php
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
        <div id="display_arcticle">
            <?php
                if(isset($_GET['articleId'])){
                    $articleId = $_GET['articleId'];
                    $sql = "SELECT * FROM `articles` JOIN `users` ON `articles`.`user_id`=`users`.`user_id` WHERE `article_id`=".$articleId.";";
                    $query = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($query)){
                        $currentArcticleId = $row['article_id'];
                        echo "<div>&nbsp;</div>";
                        echo "<div class='header_info'>";
                        echo "<label class='author'>Author:&nbsp;".strip_tags($row['name'])."</label><br>";
                        echo "<label class='title'>Title:&nbsp;".strip_tags($row['title'])."</label><br>";
                        echo "</div>";
                        if(isset($_SESSION['user_id'])){
                            echo "<div class='icon_box'>";
                            $sqlFav="SELECT * FROM `favourites` WHERE `user_id`=".$_SESSION['user_id']." AND `article_id`=".$currentArcticleId.";";
                            $queryFav= mysqli_query($conn, $sqlFav);
                            if(mysqli_num_rows($queryFav)!=0){
                                echo "<a href='../view_article/favourite_article.php?articleId=".$currentArcticleId."'><img src='../icons/star_filled.png' class='link_icon'></a>";
                            }else{
                                echo "<a href='../view_article/favourite_article.php?articleId=".$currentArcticleId."'><img src='../icons/star_empty.png' class='link_icon'></a>";
                            }
                            echo "</div>";
                        }
                        echo "<div class='content_area'>";
                        echo "<label class='content'>".nl2br($row['content'])."</label><br>";
                        echo "</div>";
                        if(isset($_SESSION['user_id'])){
                            if($row['user_id']==$_SESSION['user_id']){
                                echo "<form action='../create_article/create_article.php?articleId=".$currentArcticleId."' method='POST'>";
                                echo "<input type='submit' name='submit' class='edit_btn' value='Edit'>";
                                echo "</form>";
                            }else{
                                echo "<div class='margin_div'>&nbsp;</div>";
                            }
                        }else{
                            echo "<div class='margin_div'>&nbsp;</div>";
                        }
                    }
                }
            ?>
        </div>
        <div class="empty_div">&nbsp;</div>
    </body>
</html>

<?php
    mysqli_close($conn);
?>