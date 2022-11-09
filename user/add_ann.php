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
    <title>Nowe ogłoszenie | Transferspot</title>
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

    <!-- post editing section -->
    <section class="ann-editor">
        <h1 class="ann-editor__heading">dodaj ogłoszenie</h1>  

        <form action="" method="POST" enctype="multipart/form-data" class="ann-editor__form">
            <input type="hidden" name="username" value="<?= $fetchProfile['username']; ?>">
            <p class="ann-editor__form-text">tytuł ogłoszenia</p>
            <input type="text" name="title" required placeholder="Tytuł ogłoszenia" maxlength="100" class="ann-editor__form-box">
            <p class="ann-editor__form-text">treść ogłoszenia<span>*</span></p>
            <textarea name="content" class="ann-editor__form-box" required maxlength="10000" placeholder="Treść twojego ogłoszenia" cols="30" rows="10"></textarea>
            <p class="ann-editor__form-text">kategoria ogłoszenia<span>*</span></p>
            <select name="category" class="ann-editor__form-box" required>
                <option value="" selected disabled>-- Wybierz kategorię</option>
                <option value="need_player">Nabór zawodników</option>
                <option value="need_coach">Nabór trenerów</option>
                <option value="club_club_p">Poszukuję klubu (zawodnik)</option>
                <option value="club_club_c">Poszukuję klubu (trener)</option>
                <option value="trainings">Treningi</option>
                <option value="tournaments">Turnieje</option>
                <option value="coaching">Szkolenia</option>
                <option value="tests">Testy</option>   
            </select>
            <p class="ann-editor__form-text">województwo<span>*</span></p>
            <select name="voivodeship" class="ann-editor__form-box" required>
                <option value="" selected disabled>-- Wybierz województwo</option>
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
            <p class="ann-editor__form-text">poziom rozgrywek<span>*</span></p>
            <select name="league" class="ann-editor__form-box" required>
                <option value="" selected disabled>-- Wybierz ligę</option>
                <option value="pzpn_4">PZPN 4 liga</option>
                <option value="pzpn_5">PZPN 5 liga</option>
                <option value="wzpn_ko">WZPN Klasa okręgowa</option>
                <option value="wzpn_a">WZPN A klasa</option>
                <option value="wzpn_b">WZPN B klasa</option>
                <option value="wzpn_c">WZPN C klasa</option>   
            </select>
        </form>
    </section>
    
    <!-- JS connection -->
    <script src="../js/confirm_logout.js"></script>
    <script src="../js/user_script.js"></script>
</body>
</html>