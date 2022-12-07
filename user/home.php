<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $userId = $_SESSION['user_id'];
};

// include 'components/like_post.php';

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona główna | Transferspot</title>
    <!-- Font Awesome kit -->
    <script src="https://kit.fontawesome.com/e6c4644ded.js" crossorigin="anonymous"></script>
    <!-- google fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&family=Oswald:wght@300;400;700&display=swap" rel="stylesheet"> 
    <!-- css styles connection -->
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <!-- NAVBAR -->
    <?php
        include '../components/main_navbar.php';
    ?>
    <!-- HEADER SECTION -->
    <?php
        include '../components/main_header.php';
    ?>
    <!-- FOOTER -->
    <?php
        include '../components/footer.php';
    ?>
    
    <script src="../js/main.js"></script>
</body>
</html>