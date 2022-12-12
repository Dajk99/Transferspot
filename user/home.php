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
    <title>Strona główna | Transferspot</title>
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
    <!-- HEADER SECTION -->
    <?php
        include '../components/main_header.php';
    ?>
    <!-- STATS -->
    <section id="stats" class="home">
        <div class="home__container">
            <p class="home__container__title">statystyki</p>
            <div class="home__container__box">
                <?php
                    $selectProfile = $conn->prepare("SELECT * FROM users WHERE id = ?");
                    $selectProfile->execute([$userId]);
                    if($selectProfile->rowCount() > 0){
                    $fetchProfile = $selectProfile->fetch(PDO::FETCH_ASSOC);
                    $countUserComments = $conn->prepare("SELECT * FROM comments WHERE user_id = ?");
                    $countUserComments->execute([$userId]);
                    $totalUserComments = $countUserComments->rowCount();
                    $countUserAnns = $conn->prepare("SELECT * FROM posts WHERE user_id = ?");
                    $countUserAnns->execute([$userId]);
                    $totalUserAnns = $countUserAnns->rowCount();
                    $countUserLikes = $conn->prepare("SELECT * FROM likes WHERE user_id = ?");
                    $countUserLikes->execute([$userId]);
                    $totalUserLikes = $countUserLikes->rowCount();
                ?>
                <p class="home__container__box-text">użytkownik <span><?=$fetchProfile['username'] ?></span></p>
                <div class="home__container__box-content">
                    <a href="./comments.php" class="home__container__box-content-option">
                        <i class="fa-regular fa-comment"></i>
                        <p class="digits"><?= $totalUserComments; ?></p>
                    </a>
                    <a href="./likes.php" class="home__container__box-content-option">
                        <i class="fa-regular fa-heart"></i>
                        <p class="digits"><?= $totalUserLikes; ?></p>
                    </a>
                    <a href="./view_ann.php" class="home__container__box-content-option">
                        <i class="fa-regular fa-file-lines"></i>
                        <p class="digits"><?= $totalUserAnns; ?></p>
                    </a>
                </div>
                <?php
                    }else{
                ?>
                    <p class="home__container__box-text">aby przeglądać statystyki, komentować lub obserwować ogłoszenia <a href="./user_register.php">stwórz konto</a> lub <a href="./user_login.php">zaloguj się</a> już teraz!</p>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
    <!-- POSTS -->
    <section id="announcements" class="posts">
        <div class="posts__container">
            <p class="posts__container__title">najnowsze ogłoszenia</p>
            <div class="posts__container__box">
                <?php
                    $selectPosts = $conn->prepare("SELECT * FROM posts WHERE status = ? LIMIT 6 ");
                    $selectPosts->execute(['aktywne']);
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
                <a href="./view_ann.php?post_id=<?= $postId; ?>">
                    <form class="posts__container__box__post" method="post">
                        <input type="hidden" name="post_id" value="<?= $postId; ?>">
                        <input type="hidden" name="user_id" value="<?= $fetchPosts['user_id']; ?>">  
                            <?php
                                if($fetchPosts['image'] != ''){  
                            ?>
                                <img src="../images/<?= $fetchPosts['image']; ?>" class="posts__container__box__post-image" alt="">
                            <?php
                            }
                            ?>
                            <div class="posts__container__box__post-title"><?= $fetchPosts['title']; ?></div>
                            <div class="posts__container__box__post-tags">
                                <div class="posts__container__box__post-tags-tag">
                                    <i class="fas fa-tag"></i><?= $fetchPosts['category']; ?>
                                </div>
                                <div class="posts__container__box__post-tags-tag">
                                    <i class="fa-solid fa-location-dot"></i><?= $fetchPosts['voivodeship']; ?>
                                </div>
                                <div class="posts__container__box__post-tags-tag">
                                    <i class="fa-solid fa-futbol"></i><?= $fetchPosts['league']; ?>
                                </div>
                            </div>
                            <div class="posts__container__box__post-reactions">
                                <button><i class="fas fa-comment"></i><span>(<?= $totalPostComments; ?>)</span></button>
                                <button type="submit" name="like_post"><i class="fas fa-heart" style="<?php if($confirmLikes->rowCount() > 0){ echo 'color: $red;'; } ?>"></i><span>(<?= $totalPostLikes; ?>)</span></button>
                            </div>
                    </form>
                </a>

                <?php
                        }
                    } else {
                        echo '<p class="posts__container__box-text">Aktualnie brak aktywnych ogłoszeń!</p>';
                    }
                ?>
            </div>
        </div>
    </section>
    <!-- FOOTER -->
    <?php
        include '../components/footer.php';
    ?>
    
    <script src="../js/main.js"></script>
</body>
</html>