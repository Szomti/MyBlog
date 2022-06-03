<?php
    session_start();
    $host = "localhost";
    $user = "root";
    $dbpassword = "";
    $database = "my_blog";
    $conn = mysqli_connect($host, $user, $dbpassword, $database);

    if(isset($_POST['submit'])){
        $title = $_POST['title'];
        $content = $_POST['content'];
        $articleId = $_GET['articleId'];

        $_SESSION['tempArticleTitle'] = $title;
        $_SESSION['tempArticleContent'] = $content;

        $sql = "UPDATE `articles` SET `title`='".str_replace("'","\'",$title)."', `content`='".str_replace("'","\'",$content)."', `user_id`=".$_SESSION['user_id']." WHERE `article_id`=".$articleId.";";
        if (mysqli_query($conn, $sql)) {
            unset($_SESSION['tempArticleTitle']);
            unset($_SESSION['tempArticleContent']);
            $lastId = mysqli_insert_id($conn);
            header("Location: ../view_article/view_article.php?articleId=".$articleId, true, 303);
          } else {
              header("Location: ../create_article/create_article.php?articleId=".$articleId."&creationFailed=true");
            echo "<script>alert('Creation Failed\n')".mysqli_error($conn)."'</script>";
          }
    }

    mysqli_close($conn);
?>