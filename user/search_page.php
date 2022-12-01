<?php

@include "../components/connect.php";

session_start();

$userId = $_SESSION['user_id'];

if(!isset($userId)){
    header('location:user_login.php');
}

if(isset($_POST['delete'])) {
    $postId = $_POST['post_id'];
    $postId = filter_var($postId, FILTER_SANITIZE_STRING);
    $deleteImage = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $deleteImage->execute([$postId]);
    $fetchDeleteImage = $deleteImage->fetch(PDO::FETCH_ASSOC);
    if($fetchDeleteImage['image'] != ''){
      unlink('../images/'.$fetchDeleteImage['image']);
    }
    $deletePost = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $deletePost->execute([$postId]);
    $deleteComments = $conn->prepare("DELETE FROM comments WHERE post_id = ?");
    $deleteComments->execute([$postId]);
    $goodMessage[] = 'Pomyślnie usunięto ogłoszenie!';
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

    <section class="show-ann">
        <h1 class="show-ann__heading">twoje ogłoszenia</h1>

        <!-- search form -->
        <form action="search_page.php" method="POST" class="show-ann__form">
            <input type="text" placeholder="Szukaj..." required maxlength="100" name="search_box">
            <button name="search_btn" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>

        <div class="show-ann__container">

            <?php
                if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
                    $activePost = 'rgb(33, 197, 0)';
                    $deactivePost = 'rgba(192, 0, 0, 0.9)';
                    $searchBox = $_POST['search_box'];
                    $selectPosts = $conn->prepare("SELECT * FROM posts where user_id = ? AND title LIKE '%{$searchBox}%'");
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
            <?php
                if($fetchPosts['status'] == 'Aktywne') {
                    echo '<div class="show-ann__container__box-status" style="color:'.$activePost.';"><i class="fa-solid fa-circle-check"></i></div>';
                } else {
                    echo '<div class="show-ann__container__box-status" style="color:'.$deactivePost.';"><i class="fa-solid fa-hourglass-end"></i></div>';
                }
             ?>
            <?php if($fetchPosts['image'] != ''){ ?>
                <img src="../images/<?= $fetchPosts['image']; ?>" class="show-ann__container__box-image ann-image" alt="">
                <?php } ?>
                <div class="show-ann__container__box-title"><?= $fetchPosts['title']; ?></div>
                <div class="show-ann__container__box-content"><?= $fetchPosts['content']; ?></div>
                <div class="show-ann__container__box-icons">
                    <div class="show-ann__container__box-icons-likes"><i class="fa-solid fa-heart"></i><?= $totalPostLikes; ?></div>
                    <div class="show-ann__container__box-icons-comments"><i class="fa-solid fa-comment"></i><?= $totalPostComments; ?></div>
                </div>
                <div class="show-ann__container__box-btns">
                    <a href="edit_ann.php?post_id=<?= $postId; ?>" class="btn form-btn navy-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                    <button type="submit" name="delete" class="btn form-btn red-btn" onclick="return confirm('Wybrane ogłoszenie zostanie usunięte, kontynuować?');"><i class="fa-solid fa-trash"></i></button>
                </div>
                <button class="btn form-btn yellow-btn pd-btn-reset">
                    <a href="read_ann.php?post_id=<?= $postId; ?>" class="view">zobacz ogłoszenie</a>
                </button>
                </form>
            <?php
                        }
                    } else {
                        echo '<div class="show-ann__container-empty">brak wyników wyszukiwania. Dodaj swoje ogłoszenie klikając <a href="add_ann.php">tutaj</a></div>';
                    }
                }
            ?>
        </div>
    </section>
    
    <!-- JS connection -->
    <script src="../js/confirm_logout.js"></script>
    <script src="../js/user_script.js"></script>
</body>
</html>