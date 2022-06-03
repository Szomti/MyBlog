<?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: ../homepage/homepage.php", true, 301);
    }
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
        <title>Profile</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./profile.css">
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
                        echo "<a href='../profile/profile.php' class='top_bar_element_right current_page'>".$_SESSION['username']."</a>";
                    }else{
                        echo "<a href='../sign_in/sign_in.php' class='top_bar_element_right'>Sign In</a>";
                        echo "<a href='../sign_up/sign_up.php' class='top_bar_element_right'>Sign Up</a>";
                    }
                ?>
            </div>
        </div>
        <div id="user_data_div">
            <?php
                echo "<h2>Welcome, ".$_SESSION['username']." :D</h2>";
            ?>
            <?php
                $sql = "SELECT * FROM `favourites` JOIN `articles` ON `favourites`.`article_id`=`articles`.`article_id` JOIN `users` ON `favourites`.`user_id`=`users`.`user_id` WHERE `favourites`.`user_id`=".$_SESSION['user_id']." ORDER BY `favourites`.`add_time` DESC;";
                $query = mysqli_query($conn, $sql);
                if(mysqli_num_rows($query)!=0){
                    $favCount = 0;
                    echo "<h3>Your Last 5 Favourites:</h3>";
                    while($row = mysqli_fetch_assoc($query)){
                        $favCount += 1;
                        $currentArcticleId = $row['article_id'];
                        echo "<a href='../view_article/view_article.php?articleId=".$row['article_id']."'><div class='fav_card'>";
                        echo "<div class='card_header'>";
                        echo "<label class='author'>Author:&nbsp;".$row['name']."</label><br>";
                        echo "<label class='title'>Title:&nbsp;".$row['title']."</label><br>";
                        echo "</div>";
                        echo "<div class='icon_box'>";
                        $sqlFav="SELECT * FROM `favourites` WHERE `user_id`=".$_SESSION['user_id']." AND `article_id`=".$currentArcticleId.";";
                        $queryFav= mysqli_query($conn, $sqlFav);
                        if(mysqli_num_rows($queryFav)!=0){
                            echo "<a href='../view_article/favourite_article.php?articleId=".$currentArcticleId."'><img src='../icons/star_filled.png' class='link_icon'></a>";
                        }else{
                            echo "<a href='../view_article/favourite_article.php?articleId=".$currentArcticleId."'><img src='../icons/star_empty.png' class='link_icon'></a>";
                        }
                        echo "</div>";
                        echo "<a href='../view_article/view_article.php?articleId=".$currentArcticleId."'><div class='view_fill'>";
                        echo "&nbsp;";
                        echo "</div></a>";
                        echo "</div></a>";
                        if($favCount>=5){
                            break;
                        }
                    }
                }
            ?>
            <?php
                $sql = "SELECT * FROM `articles` WHERE `user_id`=".$_SESSION['user_id']." ORDER BY `article_id` DESC;";
                $query = mysqli_query($conn, $sql);
                if(mysqli_num_rows($query)!=0){
                    echo "<h3>Your Articles:</h3>";
                    while($row = mysqli_fetch_assoc($query)){
                        $currentArcticleId = $row['article_id'];
                        echo "<a href='../view_article/view_article.php?articleId=".$row['article_id']."'><div class='card'>";
                        echo "<div class='card_header'>";
                        echo "<label class='title'>Title:&nbsp;".$row['title']."</label><br>";
                        echo "</div>";
                        echo "<div class='icon_box'>";
                        $sqlFav="SELECT * FROM `favourites` WHERE `user_id`=".$_SESSION['user_id']." AND `article_id`=".$currentArcticleId.";";
                        $queryFav= mysqli_query($conn, $sqlFav);
                        if(mysqli_num_rows($queryFav)!=0){
                            echo "<a href='../view_article/favourite_article.php?articleId=".$currentArcticleId."'><img src='../icons/star_filled.png' class='link_icon'></a>";
                        }else{
                            echo "<a href='../view_article/favourite_article.php?articleId=".$currentArcticleId."'><img src='../icons/star_empty.png' class='link_icon'></a>";
                        }
                        echo "</div>";
                        echo "<a href='../view_article/view_article.php?articleId=".$currentArcticleId."'><div class='view_fill'>";
                        echo "&nbsp;";
                        echo "</div></a>";
                        echo "</div></a>";
                    }
                }
            ?>
        </div>
    </body>
</html>

<?php
    mysqli_close($conn);
?>