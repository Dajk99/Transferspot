<?php

@include "../components/connect.php";

session_start();

$userId = $_SESSION['user_id'];

if(!isset($userId)){
    header('location:user_login.php');
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twoje ogłoszenia | Transferspot</title>
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
    
    <!-- posts -->
    <section class="show-ann">
        <h1 class="show-ann__heading">twoje ogłoszenia</h1>

        <!-- search form -->
        <form action="search_page.php" method="POST" class="show-ann__form">
            <input type="text" class="show-ann__form-input" placeholder="Szukaj..." required maxlength="100" name="search_box">
            <button name="search_btn" class="show-ann__form-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>

        <div class="show-ann__container">
            <?php
                $activePost = 'rgb(33, 197, 0)';
                $deactivePost = '#b1b1b1';
                $selectPosts = $conn->prepare('SELECT * FROM posts WHERE user_id = ?');
                $selectPosts->execute([$userId]);

                if($selectPosts->rowCount() > 0) {
                    while($fetchPosts = $selectPosts->fetch(PDO::FETCH_ASSOC)){
                        $postId = $fetchPosts['id'];
         
                        $postComments = $conn->prepare("SELECT * FROM comments WHERE post_id = ?");
                        $postComments->execute([$postId]);
                        $totalPostComments = $postComments->rowCount();
         
                        $postLikes = $conn->prepare("SELECT * FROM likes WHERE post_id = ?");
                        $postLikes->execute([$postId]);
                        $totalPostLikes = $postLikes->rowCount();
            ?>
            <a href="read_ann.php?post_id=<?= $postId; ?>" class="show-ann__container__box">
                <input type="hidden" name="post_id" value="<?= $postId; ?>">
                <?php if($fetchPosts['image'] != ''){ ?>
                <div class="show-ann__container__box__image">
                    <img src="../images/<?= $fetchPosts['image']; ?>" class="show-ann__container__box__image-img ann-image" alt="">
                </div>
                <?php } ?>
                <div class="show-ann__container__box__content">
                    <div class="show-ann__container__box__content__title">
                        <?= $fetchPosts['title']; ?>
                    </div>
                    <div class="show-ann__container__box__content__icons">
                        <div class="show-ann__container__box__content__icons__icon"><i class="fa-solid fa-heart show-ann__container__box__content__icons__icon-likes"></i><?= $totalPostLikes; ?></div>
                        <div class="show-ann__container__box__content__icons__icon"><i class="fa-solid fa-comment show-ann__container__box__content__icons__icon-comments"></i><?= $totalPostComments; ?></div>
                    </div>
                    <?php
                    if($fetchPosts['status'] == 'Aktywne') {
                        echo '<div class="show-ann__container__box__content__status" style="color:'.$activePost.';"><p class="show-ann__container__box__content__status__text">ogłoszenie aktywne</p></div>';
                    } else {
                        echo '<div class="show-ann__container__box__content__status" style="color:'.$deactivePost.';"><p class="show-ann__container__box__content__status__text">zapisano jako szkic</p></div>';
                    }
                    ?>
                </div>
            </a>
            <?php
                    }
                } else {
                    echo '<div class="show-ann__container__empty">aktualnie nie posiadasz żadnych dodanych ogłoszeń. Dodaj swoje ogłoszenie klikając <a href="add_ann.php" class="show-ann__container__empty__link">tutaj</a></div>';
                }
            ?>
        </div>
    </section>
    
    <!-- JS connection -->
    <script src="../js/confirm_logout.js"></script>
    <script src="../js/user_script.js"></script>
</body>
</html>