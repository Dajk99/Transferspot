<?php

@include "../components/connect.php";

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    // header('location:user_login.php');
    $user_id = 1;
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel użytkownika</title>
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

    <!-- dashboard section -->
    <section class="dashboard">
        <h1 class="dashboard__heading">panel użytkownika</h1>
        <div class="dashboard__container">
            <div class="dashboard__container-box">
                <h3>witaj</h3>
                <p><?= $fetch_profile['name']; ?></p>
                <button class="btn" onclick="location.href='update_profile.php'">zaktualizuj profil</button>
            </div>
            
            <div class="dashboard__container-box">
                <?php
                    $select_posts = $conn->prepare("SELECT * FROM posts WHERE user_id = ?");
                    $select_posts->execute([$user_id]);
                    $post_count = $select_posts->rowCount();
                ?>
                <h3>suma dodanych ogłoszeń: <?= $post_count; ?></h3>
                <a href="add_ann.php" class="option"><i class="fa-solid fa-square-plus"></i>dodaj nowe ogłoszenie</a>
            </div>

            <div class="dashboard__container-box">
                <?php
                    $select_active_posts = $conn->prepare("SELECT * FROM posts WHERE user_id = ? AND status = ?");
                    $select_active_posts->execute([$user_id, 'active']);
                    $active_post_count = $select_active_posts->rowCount();
                ?>
                <h3>aktywne ogłoszenia: <?= $active_post_count; ?></h3>
                <a href="./view_ann.php" class="option"><i class="fa-solid fa-book-open"></i>przeglądaj ogłoszenia</a>
            </div>

            <div class="dashboard__container-box">
                <?php
                    $select_deactive_posts = $conn->prepare("SELECT * FROM posts WHERE user_id = ? AND status = ?");
                    $select_deactive_posts->execute([$user_id, 'deactive']);
                    $deactive_post_count = $select_deactive_posts->rowCount();
                ?>
                <h3>nieaktywne ogłoszenia: <?= $deactive_post_count; ?></h3>
                <a href="./view_ann.php" class="option"><i class="fa-solid fa-book-open"></i>przeglądaj ogłoszenia</a>
            </div>

            <div class="dashboard__container-box">
                <?php
                    $select_comments = $conn->prepare("SELECT * FROM comments WHERE user_id = ?");
                    $select_comments->execute([$user_id]);
                    $comments_count = $select_comments->rowCount();
                ?>
                <h3>komentarze: <?= $comments_count; ?></h3>
                <a href="./comments.php" class="option"><i class="fa-solid fa-book-open"></i>przeglądaj komentarze</a>
            </div>

            <div class="dashboard__container-box">
                <?php
                    $select_likes = $conn->prepare("SELECT * FROM likes WHERE user_id = ?");
                    $select_likes->execute([$user_id]);
                    $likes_count = $select_likes->rowCount();
                ?>
                <h3>polubione ogłoszenia: <?= $likes_count; ?></h3>
                <a href="./view_ann.php" class="option"><i class="fa-solid fa-book-open"></i>sprawdź polubione ogłoszenia</a>
            </div>
        </div>
    </section>
    
    <!-- JS connection -->
    <script src="../js/confirm_logout.js"></script>
    <script src="../js/user_script.js"></script>
</body>
</html>