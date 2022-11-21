<?php

@include "../components/connect.php";

session_start();

// $userId = $_SESSION['user_id'];

// if(!isset($userId)) {
//     header('location:user_header.php');
// }

if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $confPass = sha1($_POST['confirm_pass']);
    $confPass = filter_var($confPass, FILTER_SANITIZE_STRING);

    $selectUser = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $selectUser->execute([$username]);

    if($selectUser->rowCount() > 0){
        $message[] = 'Wybrana nazwa użytkownika jest już zajęta!';
    }else {
        if($pass != $confPass) {
            $message[] = 'Podane hasła się nie zgadzają!';
        } else {
            $insertUser = $conn->prepare("INSERT INTO users (email, username, password) VALUES(?,?,?)");
            $insertUser->execute([$email, $username, $confPass]); 
            $goodMessage[] = 'Konto zostało utworzone!';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja | Transferspot</title>
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

    <!-- user registration section -->
    <section class="form-container">
        <form action="" method="POST" class="form-container__form">
            <h1 class="logo"><a href="dashboard.php">Transferspot</a></h1>
            <div class="underline"></div>
            <h3 class="first-letter">Rejestracja</h3>
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
            <input type="email" required class="form-container__form-box" placeholder="Adres e-mail" maxlength="30" name="email" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="text" required class="form-container__form-box" placeholder="Nazwa użytkownika" maxlength="30" name="username" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" required class="form-container__form-box" placeholder="Hasło" maxlength="50" name="pass" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" required class="form-container__form-box" placeholder="Potwierdź hasło" maxlength="50" name="confirm_pass" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" name="submit" class="form-container__form-btn btn form-btn yellow-btn" value="Utwórz konto">
            <div class="form-container__form-info">
                <p class="first-letter">Masz już konto?</p>
                <a href="user_login.php" class="first-letter">zaloguj się</a>
            </div>
        </form>
    </section>
    
    <!-- JS connection -->
    <script src="../js/confirm_logout.js"></script>
    <script src="../js/user_script.js"></script>
</body>
</html>