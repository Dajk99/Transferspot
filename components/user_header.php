<?php /*
        if(isset($goodMessage)) {
            foreach($goodMessage as $goodMessage) {
                echo '
                <div class="good-message">
                <i class="fa-solid fa-circle-xmark" onclick="this.parentElement.remove();"></i><span>'.$goodMessage.'</span>  
                </div>
                ';
            } 
        } */
?>

<header class="header">
    
    <div class="header__logo logo">
        <a href="dashboard.php">Transferspot</a>
    </div>
    <div class="underline"></div>
    <div class="header__profile">
        <?php
        $selectProfile = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $selectProfile->execute([$userId]);
        $fetchProfile = $selectProfile->fetch(PDO::FETCH_ASSOC);
        ?>
        <p class="header__profile-text">Zalogowano jako <strong><?= $fetchProfile['username']; ?></strong></p>
    </div>
    <div class="underline"></div>

    <nav class="header__navbar navbar">
        <button class="header__navbar-item btn navy-btn first-letter" onclick="location.href='update_profile.php'"><a class="view">Zaktualizuj profil</a></button>
        <button class="header__navbar-item btn navy-btn first-letter" onclick="location.href='dashboard.php'">
            <p>panel użytkownika</p>
        </button>
        <button class="header__navbar-item btn navy-btn first-letter" onclick="location.href='add_ann.php'">
            <p>dodaj ogłoszenie</p>
        </button>
        <button class="header__navbar-item btn navy-btn first-letter" onclick="location.href='view_ann.php'">
            <p>przeglądaj ogłoszenia</p>
        </button>
        <button class="header__navbar-item btn navy-btn first-letter" onclick="location.href='user_register.php'">
            <p>zarejestruj się</p>
        </button>
        <button class="header__navbar-item header__navbar-item--login btn first-letter" onclick="location.href='user_login.php'">
            <i class="fa-solid fa-repeat"></i>
            <a class="login">przełącz konto</a>
        </button>
        <button class="header__navbar-item header__navbar-item--logout btn first-letter">
            <i class="fa-solid fa-power-off"></i>
            <a href="#" class="logout">wyloguj</a>
        </button>
    </nav>

</header>

<button class="burger-btn">
    <div class="burger-btn__box">
        <i class="fa-solid fa-bars"></i>
    </div>
</button>


