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

        $_SESSION['tempArticleTitle'] = $title;
        $_SESSION['tempArticleContent'] = $content;

        $sql = "INSERT INTO `articles`(`title`, `content`, `user_id`) VALUES ('".str_replace("'","\'",$title)."','".str_replace("'","\'",$content)."',".$_SESSION['user_id'].");";
        if (mysqli_query($conn, $sql)) {
            unset($_SESSION['tempArticleTitle']);
            unset($_SESSION['tempArticleContent']);
            $lastId = mysqli_insert_id($conn);
            header("Location: ../view_article/view_article.php?articleId=".$lastId, true, 303);
          } else {
              header("Location: ../create_article/create_article.php?creationFailed=true");
            echo "<script>alert('Creation Failed\n')".mysqli_error($conn)."'</script>";
          }
    }

    mysqli_close($conn);
?>