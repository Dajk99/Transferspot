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
    <!-- link do Font Awesome -->
    <script src="https://kit.fontawesome.com/e6c4644ded.js" crossorigin="anonymous"></script>
    <!-- Połączenie ze stylami css -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&family=Oswald:wght@300;400;700&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="../css/user_style.css">
</head>
<body>
    <!-- Sekcja header -->
    <?php
        include '../components/user_header.php';
    ?>
    <!-- Połączenie ze skryptem JS -->
    <script src="../js/user_script.js"></script>
    <script src="../js/confirm_logout.js"></script>
</body>
</html>