<?php

@include "../components/connect.php";

session_start();

$userId = $_SESSION['user_id'];

if(!isset($userId)){
    header('location:user_login.php');
}

if(isset($_POST['delete_comment'])) {
    $commentId = $_POST['comment_id'];
    $commentId = filter_var($commentId, FILTER_SANITIZE_STRING);
    $deleteComment = $conn->prepare("DELETE FROM comments WHERE id = ?");
    $deleteComment->execute([$commentId]);
    $goodMessage[] = 'Komentarz usunięty!';

}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twoje komentarze | Transferspot</title>
    <!-- Font Awesome kit -->
    <script src="https://kit.fontawesome.com/e6c4644ded.js" crossorigin="anonymous"></script>
    <!-- google fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&family=Oswald:wght@300;400;700&display=swap" rel="stylesheet"> 
    <!-- css styles connection -->
    <link rel="stylesheet" href="../css/user_style.css">
</head>
<body>
    <!-- header section -->
    <?php
        include '../components/user_header.php';
    ?>

    <?php
        if(isset($goodMessage)) {
            foreach($goodMessage as $goodMessage) {
                echo '
                <div class="good-message">
                <i class="fa-solid fa-circle-xmark" onclick="this.parentElement.remove();"></i><span>'.$goodMessage.'</span>  
                </div>
                ';
            } 
        }
    ?>

    <section class="comments show-comments">
        <p class="comments__title">twoje komentarze</p>   
        <div class="comments__container">
            <?php
                $selectComments = $conn->prepare("SELECT * FROM comments WHERE user_id = ?");
                $selectComments->execute([$userId]);
                if($selectComments->rowCount() > 0){
                    while($fetchComments = $selectComments->fetch(PDO::FETCH_ASSOC)){
            ?>

            <div class="comments__container-comment">
                <div class="comments__container-comment-user">
                    <div class="comments__container-comment-user-date">
                        <p class="comments__container-comment-user-date-text"><?= $fetchComments['date']; ?></p>
                    </div>
                    <div class="comments__container-comment-user-info">
                        <?php
                            $selectPost = $conn->prepare("SELECT * FROM posts WHERE id = ?");
                            $selectPost->execute([$fetchComments['post_id']]);
                            while($fetchPosts = $selectPost->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <p>Komentarz do ogłoszenia <span class="title-highlight"><a class=" href="read_ann.php?post_id=<?= $fetchPosts['id']; ?>" ><?= $fetchPosts['title']; ?></a></span></p>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="comments__container-comment-content"><?= $fetchComments['comment']; ?></div>
                <form class ="comments__container-comment-btn" action="" method="POST">
                    <input type="hidden" name="comment_id" value="<?= $fetchComments['id']; ?>">
                    <button type="submit" class="btn form-btn red-btn" name="delete_comment" onclick="return confirm('Komentarz zostanie usunięty. Kontynuować?');"><i class="fa-solid fa-comment-slash"></i></button>
                </form>
            </div>

            <?php
                    }
                }else{
                    echo '<div class="show-ann__container-empty">nie dodałeś do tej pory żadnego komentarza...</div>';
                }
            ?>    
        </div>         
    </section>
    
    <!-- JS connection -->
    <script src="../js/confirm_logout.js"></script>
    <script src="../js/user_script.js"></script>
</body>
</html>