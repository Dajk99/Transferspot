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
    <title>Ogłoszenia | Transferspot</title>
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
        <h1 class="show-ann__heading first-letter">twoje ogłoszenia</h1>
        <div class="show-ann__container">

            <?php
                $activePost = 'rgba(43, 255, 0, 0.6)';
                $deactivePost = 'rgba(192, 0, 0, 0.6)';
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
            <form method="post" class="show-ann__container__box">
                <input type="hidden" name="post_id" value="<?= $postId; ?>">
                <?php if($fetchPosts['image'] != ''){ ?>
                    <img src="../images/<?= $fetchPosts['image']; ?>" class="show-ann__container__box-image" alt="">
                <?php } ?>
                <?php
                if($fetchPosts['status'] == 'active') {
                    echo '<div class="show-ann__container__box-status" style="background-color:'.$activePost.';"><i class="fa-solid fa-circle-check"></i></div>';
                } else {
                    echo '<div class="show-ann__container__box-status" style="background-color:'.$deactivePost.';"><i class="fa-solid fa-hourglass-end"></i></div>';
                }
                ?>
                <div class="show-ann__container__box-title"><?= $fetchPosts['title']; ?></div>
                <div class="show-ann__container__box-content"><?= $fetchPosts['content']; ?></div>
                <div class="show-ann__container__box-icons">
                    <div class="show-ann__container__box-icons-likes"><i class="fa-solid fa-heart"></i><span><?= $totalPostLikes; ?></span></div>
                    <div class="show-ann__container__box-icons-comments"><i class="fa-solid fa-comment"></i><span><?= $totalPostComments; ?></span></div>
                </div>
                <div class="show-ann__container__box-btns">
                    <button class="btn form-btn first-letter" onclick="location.href='edit_ann.php?post_id=<?= $postId; ?>'">edytuj</button>
                    <button type="submit" name="delete" class="btn form-btn first-letter" onclick="return confirm('Na pewno usunąć to ogłoszenie?');">usuń</button>
                </div>
                <a href="read_ann.php?post_id=<?= $postId; ?>" class="btn form-btn first-letter">zobacz post</a>
            </form>
            <?php
                    }
                } else {
                    echo '<p class="show-ann__container-empty first-letter">aktualnie brak dodanych ogłoszeń</p>';
                }
            ?>
        </div>
    </section>
    
    <!-- JS connection -->
    <script src="../js/confirm_logout.js"></script>
    <script src="../js/user_script.js"></script>
</body>
</html>