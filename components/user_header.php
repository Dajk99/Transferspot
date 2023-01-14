<header class="header">
    
    <div class="header__logo">
        <a href="../user/home.php">transferspot</a>
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

    <nav class="header__navbar navbar">
        <button class="header__navbar-item btn navy-btn btn-action" onclick="location.href='update_profile.php'"><a class="view">Zaktualizuj profil</a></button>
        <button class="header__navbar-item btn navy-btn btn-action" onclick="location.href='dashboard.php'">
            <p>panel użytkownika</p>
        </button>
        <button class="header__navbar-item btn navy-btn btn-action" onclick="location.href='add_ann.php'">
            <p>dodaj ogłoszenie</p>
        </button>
        <button class="header__navbar-item btn navy-btn btn-action" onclick="location.href='view_ann.php'">
            <p>przeglądaj ogłoszenia</p>
        </button>
        <button class="header__navbar-item btn navy-btn btn-action" onclick="location.href='user_register.php'">
            <p>zarejestruj się</p>
        </button>
        <button class="header__navbar-item header__navbar-item--login btn" onclick="location.href='user_login.php'">
            <a class="login"><i class="fa-solid fa-repeat"></i><p>przełącz konto</p></a>
        </button>
        <button class="header__navbar-item header__navbar-item--logout btn">
            <a href="./user_logout.php" class="logout"><i class="fa-solid fa-power-off"></i><p>wyloguj</p></a>
        </button>
    </nav>

</header>

<button class="burger-btn">
    <div class="burger-btn__box">
        <i class="fa-solid fa-bars"></i>
    </div>
</button>


