<?php

@include "../components/connect.php";

session_start();

$userId = $_SESSION['user_id'];

if(!isset($userId)){
    header('location:user_login.php');
}

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $selectPreviousPass = $conn->prepare("SELECT password from users where id =?");
    $selectPreviousPass->execute([$userId]);
    $fetchPrevPass = $selectPreviousPass->fetch(PDO::FETCH_ASSOC);
    $prevPass = $fetchPrevPass['password'];
    $oldPass = sha1($_POST['old_pass']);
    $oldPass = filter_var($oldPass, FILTER_SANITIZE_STRING);
    $newPass = sha1($_POST['new_pass']);
    $newPass = filter_var($newPass, FILTER_SANITIZE_STRING);
    $ConfNewPass = sha1($_POST['confirm_new_pass']);
    $ConfNewPass = filter_var($ConfNewPass, FILTER_SANITIZE_STRING);

    if(empty($email) || empty($username) || empty($oldPass)) {
        $message[] = 'Niewystarczająca ilość danych!';
    } else {
        if(!empty($username)) {
            $selectUsername = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $selectUsername->execute([$username]);
    
            if($selectUsername->rowCount() > 0) {
                $message[] = 'Wybrana nazwa użytkownika jest już zajęta!';
            } else {
                $goodMessage[] = 'Zaktualizowano nazwę użytkownika!';
                $updateUsername = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
                $updateUsername->execute([$username, $userId]);
            }
        }

        if(!empty($email)) {
            $selectEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $selectEmail->execute([$email]);
    
            if($selectEmail->rowCount() > 0) {
                $message[] = 'Użytkownik z podanym adresem e-mail istnieje!';
            } else {
                $goodMessage[] = 'Zaktualizowano adres e-mail!';
                $updateEmail = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
                $updateEmail->execute([$email, $userId]);
            }
        }
        
        if($oldPass != $prevPass) {
            $message[] = 'Stare hasło się nie zgadza!';
        } else if($newPass != $ConfNewPass) {
            $message[] = 'Podane hasła się nie zgadzają!';
        } else {
            if($newPass != '') {
                $updatePassword = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $updatePassword->execute([$ConfNewPass, $userId]);
                $goodMessage[] = 'Zaktualizowano hasło!';
            } else {
                $message[] = 'Konieczne jest podanie nowego hasła!';
            }
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
    <title>Edycja profilu | Transferspot</title>
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

    <!-- profile update section -->
    <section class="form-container">
        <form action="" method="POST" class="form-container__form">
            <h3>edycja profilu</h3>
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
            <input type="email" class="form-container__form-box" placeholder="<?= $fetchProfile['email']; ?>" maxlength="30" name="email" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="text" class="form-container__form-box" placeholder="<?= $fetchProfile['username']; ?>" maxlength="30" name="username" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" class="form-container__form-box" placeholder="Stare hasło" maxlength="50" name="old_pass" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" class="form-container__form-box" placeholder="Nowe hasło" maxlength="50" name="new_pass" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" class="form-container__form-box" placeholder="Potwierdź nowe hasło" maxlength="50" name="confirm_new_pass" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" name="submit" class="form-btn btn yellow-btn" value="Zapisz zmiany">
        </form>
    </section>
    
    <!-- JS connection -->
    <script src="../js/confirm_logout.js"></script>
    <script src="../js/user_script.js"></script>
</body>
</html>