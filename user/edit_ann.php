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

if(isset($_POST['save'])) {
    $postId = $_GET['id'];
    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $content = $_POST['content'];
    $content = filter_var($content, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $voivodeship = $_POST['voivodeship'];
    $voivodeship = filter_var($voivodeship, FILTER_SANITIZE_STRING);
    $league = $_POST['league'];
    $league = filter_var($league, FILTER_SANITIZE_STRING);
    $status = $_POST['status'];
    $status = filter_var($status, FILTER_SANITIZE_STRING);

    $img = $_FILES['image']['name'];
    $img = filter_var($img, FILTER_SANITIZE_STRING);
    $imgSize = $_FILES['image']['size'];
    $imgTmpName = $_FILES['image']['tmp_name'];
    $imgFolder = '../images/'.$img;

    $selectImg = $conn->prepare('SELECT * FROM posts WHERE image = ? AND user_id = ?');
    $selectImg->execute([$img, $userId]);

    if(isset($img)){
        if($selectImg->rowCount() > 0 AND $img != ''){
           $message[] = 'Konieczna zmiana nazwy pliku!';
        }else if($imgSize > 2000000){
           $message[] = 'Załączony plik jest za duży!';
        }else{
           move_uploaded_file($imgTmpName, $imgFolder);
        }
     }else{
        $img = '';
     }

     if($selectImg->rowCount() > 0 AND $img != ''){
        $message[] = 'Zmień nazwę pliku!';
     } else {
        $insertPost = $conn->prepare('INSERT INTO posts (user_id, username, title, content, category, ligue, voivodeship, image, status) VALUES (?,?,?,?,?,?,?,?,?)');
        $insertPost->execute([$userId, $username, $title, $content, $category, $league, $voivodeship, $img, $status]);
        $goodMessage[] = 'Szkic został zapisany!';
     }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edycja ogłoszenia | Transferspot</title>
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

    <!-- edit ann -->
    <section class="ann-editor">
        <h1 class="ann-editor__heading first-letter">edytuj ogłoszenie</h1>
        
        <?php
        $postId = $_GET['id'];
        $selectPosts = $conn->prepare("SELECT * FROM posts WHERE id = ?");
        $selectPosts->execute([$postId]);
        if($selectPosts->rowCount() > 0){
            while($fetchPosts = $selectPosts->fetch(PDO::FETCH_ASSOC)){
        ?>

        <form action="" method="POST" enctype="multipart/form-data" class="ann-editor__form">
            <input type="hidden" name="post_id" value="<?= $fetchPosts['id']; ?>">
            <input type="hidden" name="username" value="<?= $fetchProfile['username']; ?>">
            <p class="ann-editor__form-text first-letter">status ogłoszenia <span>*</span></p>
            <select name="status" class="ann-editor__form-box" required>
                <option value="<?= $fetchPosts['status']; ?>" selected><?= $fetchPosts['status']; ?></option>
                <option value="active">Aktywne</option>
                <option value="deactive">Nieaktywne</option>
            </select>
            <p class="ann-editor__form-text first-letter">tytuł ogłoszenia<span>*</span></p>
            <input type="text" name="title" required placeholder="Tytuł ogłoszenia" maxlength="100" class="ann-editor__form-box" value="<?= $fetchPosts['title']; ?>">
            <p class="ann-editor__form-text first-letter">treść ogłoszenia<span>*</span></p>
            <textarea name="content" class="ann-editor__form-box" required maxlength="10000" placeholder="Treść twojego ogłoszenia" cols="30" rows="10"><?= $fetchPosts['content']; ?>"</textarea>
            <p class="ann-editor__form-text first-letter">kategoria ogłoszenia<span>*</span></p>
            <select name="category" class="ann-editor__form-box" required>
                <option value="<?= $fetchPosts['category']; ?>" selected><?= $fetchPosts['category']; ?></option>
                <option value="need_player">Nabór zawodników</option>
                <option value="need_coach">Nabór trenerów</option>
                <option value="club_club_p">Poszukuję klubu (zawodnik)</option>
                <option value="club_club_c">Poszukuję klubu (trener)</option>
                <option value="trainings">Treningi</option>
                <option value="tournaments">Turnieje</option>
                <option value="coaching">Szkolenia</option>
                <option value="tests">Testy</option>   
            </select>
            <p class="ann-editor__form-text first-letter">województwo<span>*</span></p>
            <select name="voivodeship" class="ann-editor__form-box" required>
                <option value="<?= $fetchPosts['voivodeship']; ?>" selected><?= $fetchPosts['voivodeship']; ?>"</option>
                <option value="DS">Dolnośląskie</option>
                <option value="KP">Kujawsko-Pomorskie</option>
                <option value="LU">Lubelskie</option>
                <option value="LB">Lubuskie</option>
                <option value="LD">Łódzkie</option>
                <option value="MP">Małopolskie</option>
                <option value="MZ">Mazowieckie</option>
                <option value="OP">Opolskie</option>
                <option value="PK">Podkarpackie</option>
                <option value="PD">Podlaskie</option>
                <option value="PM">Pomorskie</option>
                <option value="SL">Śląskie</option>
                <option value="SW">Świętokrzyskie</option>
                <option value="WM">Warmińsko-Mazurskie</option>
                <option value="WP">Wielkopolskie</option>
                <option value="ZP">Zachodniopomorskie</option>   
            </select>
            <p class="ann-editor__form-text first-letter">poziom rozgrywek<span>*</span></p>
            <select name="league" class="ann-editor__form-box" required>
                <option value="<?= $fetchPosts['league']; ?>" selected><?= $fetchPosts['league']; ?></option>
                <option value="pzpn_4">PZPN 4 liga</option>
                <option value="pzpn_5">PZPN 5 liga</option>
                <option value="wzpn_ko">WZPN Klasa okręgowa</option>
                <option value="wzpn_a">WZPN A klasa</option>
                <option value="wzpn_b">WZPN B klasa</option>
                <option value="wzpn_c">WZPN C klasa</option>   
            </select>
            <p class="ann-editor__form-text first-letter">Zdjęcie</p>
            <input type="file" name="image" accept="image/jpeg, image/png, image/webp" class="ann-editor__form-box">
            <?php if($fetchPosts['image'] != ''){ ?>
                <img src="../images/<?= $fetchPosts['image']; ?>" class="ann-image" alt="">
                <input type="submit" value="Usuń zdjęcie" class="btn form-btn btn-action" name="delete_image">
            <?php } ?>
            <div class="ann-editor__form-btns">
                <input type="submit" value="Zapisz zmiany" name="save" class="btn form-btn btn-action">
                <button type="submit" name="delete" class="btn form-btn" onclick="return confirm('Wybrane ogłoszenie zostanie usunięte, kontynuować?');"><i class="fa-solid fa-trash"></i></button>
            </div>
        </form>
        <?php
                    }
                } else {
                    echo '<p class="show-ann__container-empty first-letter">aktualnie brak dodanych ogłoszeń</p>';
                }
        ?>
    </section>
    
    <!-- JS connection -->
    <script src="../js/confirm_logout.js"></script>
    <script src="../js/user_script.js"></script>
</body>
</html>