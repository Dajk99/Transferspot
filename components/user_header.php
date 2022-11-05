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
        <div class="header__navbar-item">
            <i class="fa-solid fa-house"></i>
        </div>
        <div class="header__navbar-item">
            <i class="fa-solid fa-square-plus"></i>
        </div>
        <div class="header__navbar-item">
            <i class="fa-solid fa-book-open"></i>
        </div>
        <div class="header__navbar-item">
        <i class="fa-solid fa-user-plus"></i>
        </div>
        <div class="header__navbar-item header__navbar-item--login">
            <p class="header__navbar-item-text login">zaloguj</p>
        </div>
        <div class="header__navbar-item header__navbar-item--logout">
            <a href="#" class="header__navbar-item-text logout">wyloguj</a>
        </div>
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


