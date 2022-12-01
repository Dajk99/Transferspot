<?php

@include "../components/connect.php";

session_start();

$userId = $_SESSION['user_id'];

if(!isset($userId)){
    // $_SESSION['user_id'] = 1;
    header('location:user_login.php');
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel użytkownika | Transferspot</title>
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
        <h1 class="dashboard__heading ">panel użytkownika</h1>
        <div class="dashboard__container">
            <div class="dashboard__container-box">
                <?php
                    $selectPosts = $conn->prepare("SELECT * FROM posts WHERE user_id = ?");
                    $selectPosts->execute([$userId]);
                    $postCount = $selectPosts->rowCount();
                ?>
                <h3>dodane ogłoszenia: <?= $postCount; ?></h3>
                <button class="dashboard__container-box-content" onclick="location.href='add_ann.php'">
                    <i class="fa-solid fa-file-circle-plus"></i>
                    <p>dodaj nowe ogłoszenie</p>
                </button>
            </div>

            <div class="dashboard__container-box">
                <?php
                    /* liked posts */
                    $selectLikes = $conn->prepare("SELECT * FROM likes WHERE user_id = ?");
                    $selectLikes->execute([$userId]);
                    $likesCount = $selectLikes->rowCount();
                ?>
                <h3>polubione ogłoszenia: <?= $likesCount; ?></h3>
                <button class="dashboard__container-box-content" onclick="location.href='likes.php'">
                    <i class="fa-solid fa-heart"></i>
                    <p>przeglądaj polubione ogłoszenia</p>
                </button>
            </div>

            <div class="dashboard__container-box">
                <?php
                /* active posts */ 
                    $selectActivePosts = $conn->prepare("SELECT * FROM posts WHERE user_id = ? AND status = ?");
                    $selectActivePosts->execute([$userId, 'Aktywne']);
                    $activePostCount = $selectActivePosts->rowCount();
                /* deactive posts */ 
                    $selectDeactivePosts = $conn->prepare("SELECT * FROM posts WHERE user_id = ? AND status = ?");
                    $selectDeactivePosts->execute([$userId, 'Nieaktywne']);
                    $deactivePostCount = $selectDeactivePosts->rowCount();
                ?>
                <h3>aktywne ogłoszenia: <?= $activePostCount; ?></h3>
                <h3>Zapisane szkice: <?= $deactivePostCount; ?></h3>
                <button class="dashboard__container-box-content" onclick="location.href='view_ann.php'">
                    <i class="fa-solid fa-book-open"></i>
                    <p>przeglądaj dodane ogłoszenia</p>
                </button>
            </div>

            <div class="dashboard__container-box">
                <?php
                    $selectComments = $conn->prepare("SELECT * FROM comments WHERE user_id = ?");
                    $selectComments->execute([$userId]);
                    $commentsCount = $selectComments->rowCount();
                ?>
                <h3>komentarze: <?= $commentsCount; ?></h3>
                <button class="dashboard__container-box-content" onclick="location.href='comments.php'">
                    <i class="fa-solid fa-comment"></i>
                    <p>przeglądaj komentarze</p>
                </button>
            </div>
        </div>
    </section>
    
    <!-- JS connection -->
    <script src="../js/confirm_logout.js"></script>
    <script src="../js/user_script.js"></script>
</body>
</html>