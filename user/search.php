<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $userId = $_SESSION['user_id'];
} else {
    $userId = '';
};

// include 'components/like_post.php';

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wyszukiwanie | Transferspot</title>
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
    <!-- NAVBAR -->
    <?php
        include '../components/main_navbar.php';
    ?>
    <!-- POSTS -->
    <section id="announcements" class="posts">
        <div class="posts__container">
            <p class="posts__container__title top-margin">wyniki wyszukiwania</p>
            <div class="posts__container__box">
                <?php
                    if(isset($_POST['search_btn']) or isset($_POST['search_box'])) {
                        $searchText = $_POST['search_box'];
                        $selectPosts = $conn->prepare("SELECT * FROM posts WHERE status = ? AND title LIKE '%{$searchText}%' OR category LIKE '%{$searchText}%'");
                        $selectPosts->execute(['Aktywne']);
                        if($selectPosts->rowCount() > 0){
                            while($fetchPosts = $selectPosts->fetch(PDO::FETCH_ASSOC)){
                            
                            $postId = $fetchPosts['id'];

                            $countPostComments = $conn->prepare("SELECT * FROM comments WHERE post_id = ?");
                            $countPostComments->execute([$postId]);
                            $totalPostComments = $countPostComments->rowCount(); 

                            $countPostLikes = $conn->prepare("SELECT * FROM likes WHERE post_id = ?");
                            $countPostLikes->execute([$postId]);
                            $totalPostLikes = $countPostLikes->rowCount();

                            $confirmLikes = $conn->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
                            $confirmLikes->execute([$userId, $postId]);
                ?>
                <a href="./view_user_ann.php?post_id=<?= $postId; ?>" class="posts__container__box__post">
                    <input type="hidden" name="post_id" value="<?= $postId; ?>">
                    <input type="hidden" name="user_id" value="<?= $fetchPosts['user_id']; ?>">
                    <?php
                        if($fetchPosts['image'] != ''){  
                    ?>
                    <div class="posts__container__box__post__image">
                        <img src="../images/<?= $fetchPosts['image']; ?>" class="posts__container__box__post__image-img ann-image" alt="">
                    </div>
                    <?php
                    }
                    ?>
                    <div class="posts__container__box__post__content">
                        <div class="posts__container__box__post__content__title"><?= $fetchPosts['title']; ?></div>
                        <div class="posts__container__box__post__content__reactions">
                            <button><i class="fas fa-comment"></i><span><?= $totalPostComments; ?></span></button>
                            <button type="submit" name="like_post"><i class="fas fa-heart" style="<?php if($confirmLikes->rowCount() > 0){ echo 'color: $red;'; } ?>"></i><span><?= $totalPostLikes; ?></span></button>
                        </div>
                        <div class="posts__container__box__post__content__tags">
                            <div class="posts__container__box__post__content__tags__tag">
                                <i class="fas fa-tag"></i><?= $fetchPosts['category']; ?>
                            </div>
                            <div class="posts__container__box__post__content__tags__tag">
                                <i class="fa-solid fa-location-dot"></i><?= $fetchPosts['voivodeship']; ?>
                            </div>
                            <div class="posts__container__box__post__content__tags__tag">
                                <i class="fa-solid fa-futbol"></i><?= $fetchPosts['league']; ?>
                            </div>
                        </div>
                    </div>
                </a>
                <?php
                            }
                        } else {
                            echo '<div class="posts__container__box__info">
                            <p>Nie znaleziono ogłoszeń dla frazy <span>'.$searchText.'</span></p>
                            </div>';
                        }
                }
                ?>
            </div>
            <a href="./home.php#announcements"><i class="fa-solid fa-arrow-left comeback-arrow"></i></a>
        </div>
    </section>  
    <script src="../js/main.js"></script>
</body>
</html>