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
        <p>Witaj, <?= $fetch_profile['name']; ?></p>
        <button class="btn" onclick="location.href='/user/update_profile.php'">zaktualizuj profil</button>
    </div>

    <nav class="header__navbar navbar">
        <a href="/user/dashboard.php" class="option"><i class="fa-solid fa-house"></i>strona główna</a>
        <!-- <button class="option" onclick="location.href='add_ann.php'">
            <i class="fa-solid fa-square-plus"></i>dodaj ogłoszenie
        </button> -->
        <a href="/user/add_ann.php" class="option"><i class="fa-solid fa-square-plus"></i>dodaj ogłoszenie</a>
        <!-- <button class="option" onclick="location.href='view_ann.php'">
            <i class="fa-solid fa-book-open"></i>przeglądaj ogłoszenia
        </button> -->
        <a href="/user/view_ann.php" class="option"><i class="fa-solid fa-book-open"></i>przeglądaj ogłoszenia</a>
        <a href="" class="option logout">
            <i class="fa-solid fa-right-from-bracket"></i>wyloguj
        </a>
        <!-- <a href="admin_accounts.php"><i class="fas fa-user"></i>konta</a> -->
    </nav>

    <div class="header__flex-btn">
        <a href="/user/user_login.php" class="option-btn">logowanie</a>
        <a href="/user/user_register.php" class="option-btn">rejestracja</a>
    </div>
</header>

<button class="burger-btn">
    <div class="burger-btn__box">
        <i class="fa-solid fa-bars"></i>
    </div>
</button>


