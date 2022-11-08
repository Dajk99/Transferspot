<?php

@include "../components/connect.php";

session_start();

if(isset($_POST['submit'])){

    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $select_user->execute([$username, $pass]);

    if($select_user->rowCount() > 0){
        $message[] = 'Przetwarzanie...';
    }else {
       $message[] = 'Nieprawidłowe hasło lub nazwa użytkownika!'; 
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie | Transferspot</title>
    <!-- Font Awesome kit -->
    <script src="https://kit.fontawesome.com/e6c4644ded.js" crossorigin="anonymous"></script>
    <!-- google fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&family=Oswald:wght@300;400;700&display=swap" rel="stylesheet"> 
    <!-- css styles connection -->
    <link rel="stylesheet" href="../css/user_style.css">
</head>

<body class="pd-reset">

    <!-- user login section -->
    <section class="form-container">
        <form action="" method="POST" class="form-container__form">
            <h3 class="first-letter">logowanie</h3>
            <?php
                if(isset($message)) {
                foreach($message as $message) {
                    echo '
                    <div class="message">
                        <i class="fa-solid fa-circle-xmark" onclick="this.parentElement.remove();"></i><span>'.$message.'</span>  
                    </div>
                    ';
                    } 
                }
            ?>
            <input type="text" required class="form-container__form-box" placeholder="Nazwa użytkownika" maxlength="30" name="username" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" required class="form-container__form-box" placeholder="Hasło" maxlength="50" name="pass" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" name="submit" class="form-container__form-btn btn btn-action" value="Zaloguj się">
        </form>
    </section>
    
    <!-- JS connection -->
    <script src="../js/confirm_logout.js"></script>
    <script src="../js/user_script.js"></script>
</body>
</html>