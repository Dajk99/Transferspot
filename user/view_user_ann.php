<?php

@include "../components/connect.php";

session_start();

if(isset($_SESSION['user_id'])){
    $userId = $_SESSION['user_id'];
 } else {
     $userId = '';
 };
 
$getId = $_GET['post_id'];

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zobacz ogłoszenie | Transferspot</title>
    <!-- Font Awesome kit -->
    <script src="https://kit.fontawesome.com/e6c4644ded.js" crossorigin="anonymous"></script>
    <!-- google fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&family=Oswald:wght@300;400;700&display=swap" rel="stylesheet"> 
    <!-- css styles connection -->
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <!-- header section -->
    <?php
        include '../components/main_navbar.php';
    ?>
    
    <!-- posts -->
    <section class="posts">
        <div class="posts__container">
            <div class="posts__container__box">
                <?php
                    $selectPosts = $conn->prepare('SELECT * FROM posts WHERE id = ?');
                    $selectPosts->execute([$getId]);

                    if($selectPosts->rowCount() > 0) {
                        while($fetchPosts = $selectPosts->fetch(PDO::FETCH_ASSOC)){
                            $postId = $fetchPosts['id'];
                            $postCategory = $fetchPosts['category'];
                            $postVoivodeship = $fetchPosts['voivodeship'];
                            $postLeague = $fetchPosts['league'];
                
                            $postComments = $conn->prepare("SELECT * FROM comments WHERE post_id = ?");
                            $postComments->execute([$postId]);
                            $totalPostComments = $postComments->rowCount();
                
                            $postLikes = $conn->prepare("SELECT * FROM likes WHERE post_id = ?");
                            $postLikes->execute([$postId]);
                            $totalPostLikes = $postLikes->rowCount();

                            $confirmLikes = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
                            $confirmLikes->execute([$userId, $postId]);
                ?>
                <form method="post" class="posts__container__box__post top-margin">
                    <input type="hidden" name="post_id" value="<?= $postId; ?>">
                    <?php if($fetchPosts['image'] != ''){ ?>
                    <div class="posts__container__box__post__image">
                        <img src="../images/<?= $fetchPosts['image']; ?>" class="posts__container__box__post__image-img ann-image" alt="">
                    </div>
                    <?php } ?>
                    <div class="posts__container__box__post__content">
                        <div class="posts__container__box__post__content__title left"><?= $fetchPosts['title']; ?></div>
                        <div class="posts__container__box__post__content__reactions left">
                                <button><i class="fas fa-comment"></i><span><?= $totalPostComments; ?></span></button>
                                <button type="submit" name="like_post"><i class="fas fa-heart" style="<?php if($confirmLikes->rowCount() > 0){ echo 'color: $red;'; } ?>"></i><span><?= $totalPostLikes; ?></span></button>
                        </div>
                        <div class="posts__container__box__post__content__tags left">
                            <div class="posts__container__box__post__content__tags__tag"><i class="fa-solid fa-tag"></i><?= $postCategory?></div>
                            <div class="posts__container__box__post__content__tags__tag"><i class="fa-solid fa-location-dot"></i><?= $postVoivodeship?></div>
                            <div class="posts__container__box__post__content__tags__tag"><i class="fa-solid fa-futbol"></i><?= $postLeague?></div>
                        </div>
                        <div class="post_underline"></div>
                        <div class="posts__container__box__post__content__text"><?= $fetchPosts['content']; ?></div>
                        <div class="post_underline"></div>
                        <div class="posts__container__box__post__content__info">
                            <div class="posts__container__box__post__content__info__date">
                                <p><?= $fetchPosts['date']?></p>
                            </div>
                            <div class="posts__container__box__post__content__info__user">
                                <i class="fa-solid fa-user"></i>
                                <p><?= $fetchPosts['username']?></p>
                            </div>
                        </div>
                    </div>
                </form>
                <?php
                        }
                    }
                ?>
            </div>
        </div>
    </section>

    <section class="comments">   
        <div class="comments__container">
            <div class="comments__container-title">komentarze</div>
            <?php
                $selectComments = $conn->prepare("SELECT * FROM comments WHERE post_id = ?");
                $selectComments->execute([$getId]);
                if($selectComments->rowCount() > 0){
                    while($fetchComments = $selectComments->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class="comments__container-comment">
                <div class="comments__container-comment-user">
                    <div class="comments__container-comment-user-date">
                        <p class="comments__container-comment-user-date-text"><?= $fetchComments['date']; ?></p>
                    </div>
                    <div class="comments__container-comment-user-info">
                        <p class="username-highlight"><?= $fetchComments['username']; ?></p>
                    </div>
                </div>
                <div class="comments__container-comment-content"><?= $fetchComments['comment']; ?></div>
            </div>
            <?php
                    }
                }else{
                    echo '<p class="comments__container-text">Brak komentarzy...</p>';
                }
            ?>
            <a href="./home.php#home"><i class="fa-solid fa-arrow-left comeback-arrow"></i></a>    
        </div>         
    </section>
    
    <!-- JS connection -->
    <script src="../js/main.js"></script>
</body>
</html>