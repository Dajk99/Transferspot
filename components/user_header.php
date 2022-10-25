<header class="header">

<a href="/user/dashboard.php" class="header__logo">panel użytkownika</a>

<div class="header__profile">
    <?php
    $select_profile = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $select_profile->execute([$user_id]);
    $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
    ?>
    <p><?= $fetch_profile['name']; ?></p>
    <a href="update_profile.php" class="header__btn btn">zaktualizuj profil</a>
</div>

<nav class="header__navbar navbar">
    <a href="dashboard.php"><i class="fa-solid fa-house"></i>strona główna</a>
    <a href="add_ann.php"><i class="fa-solid fa-square-plus"></i>dodaj ogłoszenie</a>
    <a href="view_ann.php"><i class="fa-solid fa-book-open"></i>przeglądaj ogłoszenia</a>
    <!-- <a href="admin_accounts.php"><i class="fas fa-user"></i>konta</a> -->
    <a href="/components/user_logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i>wyloguj</a>
</nav>

<div class="header__flex-btn">
    <a href="/user/user_login.php" class="option-btn">zaloguj się</a>
    <a href="/user/user_register.php" class="option-btn">zarejestruj się</a>
</div>

</header>

