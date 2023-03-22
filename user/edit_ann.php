<?php

@include "../components/connect.php";

session_start();

$userId = $_SESSION['user_id'];

if(!isset($userId)){
    header('location:user_login.php');
}

if(isset($_POST['save'])) {
    $postId = $_GET['post_id'];
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

    $updatePost = $conn->prepare("UPDATE posts SET title = ?, content = ?, category = ?, voivodeship = ?, league = ?, status = ? WHERE id = ?");
    $updatePost->execute([$title, $content, $category, $voivodeship, $league, $status, $postId]);
    $goodMessage[] = 'Pomyślnie zaktualizowano ogłoszenie!';

    $oldImage = $_POST['old_image'];
    $oldImage = filter_var($oldImage, FILTER_SANITIZE_STRING);
    $img = $_FILES['image']['name'];
    $img = filter_var($img, FILTER_SANITIZE_STRING);
    $imgSize = $_FILES['image']['size'];
    $imgTmpName = $_FILES['image']['tmp_name'];
    $imgFolder = '../images/'.$img;

    $selectImg = $conn->prepare('SELECT * FROM posts WHERE image = ? AND user_id = ?');
    $selectImg->execute([$img, $userId]);

    if(!empty($img)){
        if($imgSize > 2000000){
            $message[] = 'Załączony plik jest za duży!';
        } else if($selectImg->rowCount() > 0 AND $img != ''){
            $message[] = 'Zmień nazwę pliku!';
        } else{
            $updateImage = $conn->prepare("UPDATE posts SET image = ? WHERE id = ?");
            $updateImage->execute([$img, $postId]);
            move_uploaded_file($imgTmpName, $imgFolder);
            if($oldImage != $img AND $oldImage != '') {
                unlink('../images/'.$oldImage);
            }
            $goodMessage[] = 'Pomyślnie zaktualizowano zdjęcie!';
        }
     } else{
        $img = '';
     }
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
 
if(isset($_POST['delete_image'])){
    $emptyImg = '';
    $postId = $_POST['post_id'];
    $postId = filter_var($postId, FILTER_SANITIZE_STRING);
    $deleteImage = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $deleteImage->execute([$postId]);
    $fetchDeleteImage = $deleteImage->fetch(PDO::FETCH_ASSOC);
    if($fetchDeleteImage['image'] != ''){
       unlink('../images/'.$fetchDeleteImage['image']);
    }
    $unsetImage = $conn->prepare("UPDATE `posts` SET image = ? WHERE id = ?");
    $unsetImage->execute([$emptyImg, $postId]);
    $goodMessage[] = 'Zdjęcie zostało usunięte!';
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

    <!-- edit ann -->
    <section class="ann-editor">
        <h1 class="ann-editor__heading">edytuj ogłoszenie</h1>
        
        <?php
        $postId = $_GET['post_id'];
        $selectPosts = $conn->prepare("SELECT * FROM posts WHERE id = ?");
        $selectPosts->execute([$postId]);
        if($selectPosts->rowCount() > 0){
            while($fetchPosts = $selectPosts->fetch(PDO::FETCH_ASSOC)){
        ?>

        <form action="" method="POST" enctype="multipart/form-data" class="ann-editor__form">
            <input type="hidden" name="post_id" value="<?= $fetchPosts['id']; ?>">
            <input type="hidden" name="old_image" value="<?= $fetchPosts['image']; ?>">
            <input type="hidden" name="username" value="<?= $fetchProfile['username']; ?>">
            <p class="ann-editor__form-text">status ogłoszenia <span>*</span></p>
            <select name="status" class="ann-editor__form-box" required>
                <option hidden selected><?= $fetchPosts['status']; ?></option>
                <option value="Aktywne">Aktywne</option>
                <option value="Szkic">Szkic</option>
            </select>
            <p class="ann-editor__form-text">tytuł ogłoszenia<span>*</span></p>
            <input type="text" name="title" required placeholder="Tytuł ogłoszenia" maxlength="100" class="ann-editor__form-box" value="<?= $fetchPosts['title']; ?>">
            <p class="ann-editor__form-text">treść ogłoszenia<span>*</span></p>
            <textarea name="content" class="ann-editor__form-box" required maxlength="10000" placeholder="Treść twojego ogłoszenia" cols="30" rows="10"><?= $fetchPosts['content']; ?></textarea>
            <p class="ann-editor__form-text">kategoria ogłoszenia<span>*</span></p>
            <select name="category" class="ann-editor__form-box" required>
                <option value="<?= $fetchPosts['category']; ?>" selected><?= $fetchPosts['category']; ?></option>
                <option value="Nabór zawodników">Nabór zawodników</option>
                <option value="Nabór trenerów">Nabór trenerów</option>
                <option value="Zawodnik szuka pracy">Zawodnik szuka pracy</option>
                <option value="Trener szuka pracy">Trener szuka pracy</option>
                <option value="Treningi">Treningi</option>
                <option value="Turnieje">Turnieje</option>
                <option value="Szkolenia">Szkolenia</option>
                <option value="Testy">Testy</option>    
            </select>
            <p class="ann-editor__form-text">województwo<span>*</span></p>
            <select name="voivodeship" class="ann-editor__form-box" required>
                <option value="<?= $fetchPosts['voivodeship']; ?>" selected><?= $fetchPosts['voivodeship']; ?></option>
                <option value="Dolnośląskie">Dolnośląskie</option>
                <option value="Kujawsko-Pomorskie">Kujawsko-Pomorskie</option>
                <option value="Lubelskie">Lubelskie</option>
                <option value="Lubuskie">Lubuskie</option>
                <option value="Łódzkie">Łódzkie</option>
                <option value="Małopolskie">Małopolskie</option>
                <option value="Mazowieckie">Mazowieckie</option>
                <option value="Opolskie">Opolskie</option>
                <option value="Podkarpackie">Podkarpackie</option>
                <option value="Podlaskie">Podlaskie</option>
                <option value="Pomorskie">Pomorskie</option>
                <option value="Śląskie">Śląskie</option>
                <option value="Świętokrzyskie">Świętokrzyskie</option>
                <option value="Warmińsko-Mazurskie">Warmińsko-Mazurskie</option>
                <option value="Wielkopolskie">Wielkopolskie</option>
                <option value="Zachodniopomorskie">Zachodniopomorskie</option>  
            </select>
            <p class="ann-editor__form-text">poziom rozgrywek<span>*</span></p>
            <select name="league" class="ann-editor__form-box" required>
                <option value="<?= $fetchPosts['league']; ?>" selected><?= $fetchPosts['league']; ?></option>
                <option value="PZPN 4 liga">PZPN 4 liga</option>
                <option value="PZPN 5 liga">PZPN 5 liga</option>
                <option value="WZPN Klasa okręgowa">WZPN Klasa okręgowa</option>
                <option value="WZPN A klasa">WZPN A klasa</option>
                <option value="WZPN B klasa">WZPN B klasa</option>
                <option value="WZPN C klasa">WZPN C klasa</option>   
            </select>
            <p class="ann-editor__form-text">Zdjęcie</p>
            <input type="file" name="image" accept="image/jpeg, image/png, image/webp" class="ann-editor__form-box">
            <?php if($fetchPosts['image'] != ''){ ?>
                <img src="../images/<?= $fetchPosts['image']; ?>" class="ann-image" alt="">
                <button type="submit" class="btn form-btn gray-btn" name="delete_image"><i class="fa-solid fa-trash"></i><p>usuń zdjęcie</p></button>
            <?php } ?>
            <div class="ann-editor__form-btns">
                <button type="submit" name="save" class="btn form-btn green-btn"><i class="fa-solid fa-file-circle-check"></i><p>zapisz zmiany</p></button>
                <button type="submit" name="delete" class="btn form-btn red-btn" onclick="return confirm('Wybrane ogłoszenie zostanie usunięte, kontynuować?');"><i class="fa-solid fa-file-circle-xmark"></i><p>usuń ogłoszenie</p></button>
            </div>
            <div class="ann-editor__form-comeback">
                <a href="view_ann.php">Wróć do ogłoszeń</a>
            </div>
        </form>
        <?php
                }
            } else {
                echo '<div class="show-ann__container-empty">aktualnie nie posiadasz żadnych dodanych ogłoszeń. Dodaj swoje ogłoszenie klikając <a href="add_ann.php">tutaj</a></div>';
            }
        ?>
    </section>
    
    <!-- JS connection -->
    <script src="../js/confirm_logout.js"></script>
    <script src="../js/user_script.js"></script>
</body>
</html>