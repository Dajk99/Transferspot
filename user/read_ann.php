<?php
    @include "../components/connect.php";

    session_start();

    $userId = $_SESSION['user_id'];

    if(!isset($userId)){
        header('location:user_login.php');
    }

    $getId = $_GET['post_id'];

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
        header('location:view_ann.php');
        $goodMessage[] = 'Ogłoszenie zostało usunięte!';
    }

    if(isset($_POST['delete_comment'])) {
        $commentId = $_POST['comment_id'];
        $commentId = filter_var($commentId, FILTER_SANITIZE_STRING);
        $deleteComment = $conn->prepare("DELETE FROM comments WHERE id = ?");
        $deleteComment->execute([$commentId]);
        $goodMessage[] = 'Komentarz usunięty!';

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

    <!-- read ann section -->
    <section class="read-ann">
        <?php
            $activePost = 'rgb(33, 197, 0)';
            $deactivePost = 'rgba(192, 0, 0, 0.9)';
            $selectPosts = $conn->prepare('SELECT * FROM posts WHERE id = ? AND user_id = ?');
            $selectPosts->execute([$getId, $userId]);

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
        ?>
        <form method="post" class="show-ann__container__box .read-ann">
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
            <div class="show-ann__container__box-tags">
                <div class="show-ann__container__box-tags-tag"><i class="fa-solid fa-tag"></i><?= $postCategory?></div>
                <div class="show-ann__container__box-tags-tag"><i class="fa-solid fa-location-dot"></i><?= $postVoivodeship?></div>
                <div class="show-ann__container__box-tags-tag"><i class="fa-solid fa-futbol"></i><?= $postLeague?></div>
            </div>
            <div class="show-ann__container__box-content no-slice"><?= $fetchPosts['content']; ?></div>
            <div class="show-ann__container__box-icons">
                <div class="show-ann__container__box-icons-likes"><i class="fa-solid fa-heart"></i><?= $totalPostLikes; ?></div>
                <div class="show-ann__container__box-icons-comments"><i class="fa-solid fa-comment"></i><?= $totalPostComments; ?></div>
            </div>
            <div class="show-ann__container__box-btns">
                <a href="edit_ann.php?post_id=<?= $postId; ?>" class="btn form-btn navy-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                <button type="submit" name="delete" class="btn form-btn red-btn" onclick="return confirm('Wybrane ogłoszenie zostanie usunięte, kontynuować?');"><i class="fa-solid fa-trash"></i></button>
            </div>
            <div class="ann-editor__form-comeback">
                <a href="view_ann.php">Wróć do ogłoszeń</a>
            </div>
        </form>
        <?php
                }
            } else {
                echo '<div class="show-ann__container-empty first-letter">aktualnie nie posiadasz żadnych dodanych ogłoszeń. Dodaj swoje ogłoszenie klikając <a href="add_ann.php">tutaj</a></div>';
                }
        ?>
    </section>

    <section class="comments">
        <p class="comments__title first-letter">komentarze</p>   
        <div class="comments__container">
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
                        <p>Użytkownik <span class="username-highlight"><?= $fetchComments['username']; ?></span> napisał:<p>
                    </div>
                </div>
                <div class="comments__container-comment-content first-letter"><?= $fetchComments['comment']; ?></div>
                <form class ="comments__container-comment-btn" action="" method="POST">
                    <input type="hidden" name="comment_id" value="<?= $fetchComments['id']; ?>">
                    <button type="submit" class="btn form-btn red-btn" name="delete_comment" onclick="return confirm('Komentarz zostanie usunięty. Kontynuować?');"><i class="fa-solid fa-comment-slash"></i></button>
                </form>
            </div>

            <?php
                    }
                }else{
                    echo '<div class="show-ann__container-empty first-letter">brak komentarzy...</div>';
                }
            ?>    
        </div>         
    </section>
    
    <!-- JS connection -->
    <script src="../js/confirm_logout.js"></script>
    <script src="../js/user_script.js"></script>
</body>
</html>