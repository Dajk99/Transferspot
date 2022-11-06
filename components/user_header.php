<header class="header">
    <div class="header__logo">
        <a href="/user/dashboard.php">Transferspot</a>
    </div>

    <div class="header__profile">
        <?php
        $select_profile = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $select_profile->execute([$user_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <p class="header__profile-text">Witaj, <?= $fetch_profile['name']; ?></p>
        <button class="header__profile-btn btn" onclick="location.href='/user/update_profile.php'">zaktualizuj profil</button>
    </div>

    <nav class="header__navbar navbar">
        <button class="header__navbar-item btn" onclick="location.href='dashboard.php'">
            <i class="fa-solid fa-house"></i>
            <p>strona główna</p>
        </button>
        <button class="header__navbar-item btn" onclick="location.href='add_ann.php'">
            <i class="fa-solid fa-square-plus"></i>
            <p>dodaj ogłoszenie</p>
        </button>
        <button class="header__navbar-item btn" onclick="location.href='view_ann.php'">
            <i class="fa-solid fa-book-open"></i>
            <p>przeglądaj ogłoszenia</p>
        </button>
        <button class="header__navbar-item btn" onclick="location.href='user_register.php'">
            <i class="fa-solid fa-user-plus"></i>
            <p>zarejestruj się</p>
        </button>
        <button class="header__navbar-item header__navbar-item--login btn" onclick="location.href='user_login.php'">
            <p class="header__navbar-item-text login">zaloguj</p>
        </button>
        <button class="header__navbar-item header__navbar-item--logout btn">
            <a href="#" class="header__navbar-item-text logout">wyloguj</a>
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


