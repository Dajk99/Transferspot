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
    <div class="header__logo">
        <a href="dashboard.php">Transferspot</a>
    </div>

    <div class="header__profile">
        <?php
        $selectProfile = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $selectProfile->execute([$userId]);
        $fetchProfile = $selectProfile->fetch(PDO::FETCH_ASSOC);
        ?>
        <p class="header__profile-text">Zalogowano jako <strong><?= $fetchProfile['username']; ?></strong></p>
    </div>

    <nav class="header__navbar navbar">
        <!-- <button class="header__navbar-item btn first-letter" onclick="location.href='dashboard.php'">
            <i class="fa-solid fa-house"></i>
            <p>strona główna</p>
        </button> -->
        <button class="header__navbar-opt btn first-letter btn-action" onclick="location.href='update_profile.php'"><a class="view">Zaktualizuj profil</a></button>
        <button class="header__navbar-item btn first-letter" onclick="location.href='dashboard.php'">
            <i class="fa-solid fa-gear"></i>
            <p>panel użytkownika</p>
        </button>
        <button class="header__navbar-item btn first-letter" onclick="location.href='add_ann.php'">
            <i class="fa-solid fa-square-plus"></i>
            <p>dodaj ogłoszenie</p>
        </button>
        <button class="header__navbar-item btn first-letter" onclick="location.href='view_ann.php'">
            <i class="fa-solid fa-book-open"></i>
            <p>przeglądaj ogłoszenia</p>
        </button>
        <button class="header__navbar-item btn first-letter" onclick="location.href='user_register.php'">
            <i class="fa-solid fa-user-plus"></i>
            <p>zarejestruj się</p>
        </button>
        <button class="header__navbar-opt header__navbar-opt--login btn btn-action first-letter" onclick="location.href='user_login.php'">
            <a class="login">zaloguj</a>
        </button>
        <button class="header__navbar-opt header__navbar-opt--logout btn btn-action first-letter">
            <a href="#" class="logout">wyloguj</a>
        </button>
        <!-- <a href="/user/dashboard.php" class="header__navbar-option"><i class="fa-solid fa-house"></i>strona główna</a>
        <a href="/user/add_ann.php" class="header__navbar-option"><i class="fa-solid fa-square-plus"></i>dodaj ogłoszenie</a>
        <a href="/user/view_ann.php" class="header__navbar-option"><i class="fa-solid fa-book-open"></i>przeglądaj ogłoszenia</a>
        <a href="" class="header__navbar-option logout">
            <i class="fa-solid fa-right-from-bracket"></i>wyloguj
        </a> -->
    </nav>

    <!-- <div class="header__flex-btn">
        <a href="/user/user_login.php" class="option-btn">logowanie</a>
        <a href="/user/user_register.php" class="option-btn">rejestracja</a>
    </div> -->
</header>

<button class="burger-btn">
    <div class="burger-btn__box">
        <i class="fa-solid fa-bars"></i>
    </div>
</button>


