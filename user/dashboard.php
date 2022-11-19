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
        <h1 class="dashboard__heading first-letter">panel użytkownika</h1>
        <div class="dashboard__container">
            <div class="dashboard__container-box">
                <h3 class="first-letter">witaj, <?= $fetchProfile['username']; ?></h3>
                <button class="dashboard__container-box-btn btn form-btn first-letter btn-action" onclick="location.href='update_profile.php'">zaktualizuj profil</button>
            </div>
            
            <div class="dashboard__container-box">
                <?php
                    $selectPosts = $conn->prepare("SELECT * FROM posts WHERE user_id = ?");
                    $selectPosts->execute([$userId]);
                    $postCount = $selectPosts->rowCount();
                ?>
                <h3 class="first-letter">suma dodanych ogłoszeń: <?= $postCount; ?></h3>
                <button class="dashboard__container-box-btn btn form-btn first-letter btn-action" onclick="location.href='add_ann.php'">dodaj nowe ogłoszenie</button>
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
                /* liked posts */
                    $selectLikes = $conn->prepare("SELECT * FROM likes WHERE user_id = ?");
                    $selectLikes->execute([$userId]);
                    $likesCount = $selectLikes->rowCount();
                ?>
                <h3 class="first-letter">aktywne ogłoszenia: <?= $activePostCount; ?></h3>
                <h3 class="first-letter">Wygasłe ogłoszenia: <?= $deactivePostCount; ?></h3>
                <h3 class="first-letter">polubione ogłoszenia: <?= $likesCount; ?></h3>
                <button class="dashboard__container-box-btn btn form-btn first-letter btn-action" onclick="location.href='view_ann.php'">przeglądaj ogłoszenia</button>
            </div>

            <div class="dashboard__container-box">
                <?php
                    $selectComments = $conn->prepare("SELECT * FROM comments WHERE user_id = ?");
                    $selectComments->execute([$userId]);
                    $commentsCount = $selectComments->rowCount();
                ?>
                <h3 class="first-letter">komentarze: <?= $commentsCount; ?></h3>
                <button class="dashboard__container-box-btn btn form-btn first-letter btn-action" onclick="location.href='comments.php'">przeglądaj komentarze</button>
            </div>
        </div>
    </section>
    
    <!-- JS connection -->
    <script src="../js/confirm_logout.js"></script>
    <script src="../js/user_script.js"></script>
</body>
</html>