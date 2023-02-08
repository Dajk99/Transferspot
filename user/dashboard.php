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

            <a href="./view_ann.php">
                <div class="dashboard__container-box">
                    <?php
                    /* active posts */ 
                        $selectActivePosts = $conn->prepare("SELECT * FROM posts WHERE user_id = ? AND status = ?");
                        $selectActivePosts->execute([$userId, 'Aktywne']);
                        $activePostCount = $selectActivePosts->rowCount();
                    ?>
                    <h3 class="dashboard__container-box-text">aktywne ogłoszenia</h3>
                    <i class="fa-solid fa-book-open dashboard__container-box-icon"></i>
                    <p class="dashboard__container-box-number"><?= $activePostCount; ?></p>
                </div>
            </a>

            <a href="./view_ann.php">
                <div class="dashboard__container-box">
                    <?php
                        /* deactive posts */ 
                        $selectDeactivePosts = $conn->prepare("SELECT * FROM posts WHERE user_id = ? AND status = ?");
                        $selectDeactivePosts->execute([$userId, 'Nieaktywne']);
                        $deactivePostCount = $selectDeactivePosts->rowCount();
                    ?>
                    <h3 class="dashboard__container-box-text">Zapisane szkice</h3>
                    <i class="fa-solid fa-file-pen dashboard__container-box-icon"></i>
                    <p class="dashboard__container-box-number"><?= $deactivePostCount; ?></p>
                </div>
            </a>

            <a href="./likes.php">
                <div class="dashboard__container-box">
                    <?php
                        /* liked posts */
                        $selectLikes = $conn->prepare("SELECT * FROM likes WHERE user_id = ?");
                        $selectLikes->execute([$userId]);
                        $likesCount = $selectLikes->rowCount();
                    ?>
                    <h3 class="dashboard__container-box-text">polubione ogłoszenia</h3>
                    <i class="fa-solid fa-heart dashboard__container-box-icon"></i>
                    <p class="dashboard__container-box-number"><?= $likesCount; ?></p>
                </div>
            </a>

            <a href="./comments.php">
                <div class="dashboard__container-box">
                    <?php
                        /* comments */
                        $selectComments = $conn->prepare("SELECT * FROM comments WHERE user_id = ?");
                        $selectComments->execute([$userId]);
                        $commentsCount = $selectComments->rowCount();
                    ?>
                    <h3 class="dashboard__container-box-text">komentarze</h3>
                    <i class="fa-solid fa-comment dashboard__container-box-icon"></i>
                    <p class="dashboard__container-box-number"><?= $commentsCount; ?></p>
                </div>
            </a>
        </div>
    </section>
    
    <!-- JS connection -->
    <script src="../js/confirm_logout.js"></script>
    <script src="../js/user_script.js"></script>
</body>
</html>