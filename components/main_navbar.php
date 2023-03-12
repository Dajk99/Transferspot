<nav class="navbar">
    <!-- MOBILE -->
    <div class="navbar__mobile active-nav-bg">
        <div class="navbar__mobile-btns">
            <button class="navbar__mobile-btns-btn" onclick="location.href='./home.php#home'"><i class="fa-solid fa-house"></i></button>
            <button class="navbar__mobile-btns-btn navbar__mobile-btns-btn-burger"><i class="fa-solid fa-bars"></i></button>
            <?php
                if ($userId !== '') {
                    echo '<button class="navbar__mobile-btns-btn" onclick="location.href=\'../components/user_logout.php\'" confirm=""><i class="fa-solid fa-power-off"></i></button>';
                }
            ?>
        </div>
        <a href="./home.php#stats" class="navbar__mobile-item deactive">statystyki</a>
        <a href="./home.php#announcements" class="navbar__mobile-item deactive">ogłoszenia</a>
        <a href="./home.php#categories" class="navbar__mobile-item deactive">kategorie</a>
        <?php 
            if ($userId !== '') {
                echo '<a href="dashboard.php" class="navbar__mobile-item deactive">panel użytkownika</a>';
            } else {
                echo '<a href="user_login.php" class="navbar__mobile-item deactive">zaloguj się</a>
                <a href="user_register.php" class="navbar__mobile-item deactive">zarejestruj się</a>';
            };
        ?>
    </div>

    <!-- DESKTOP -->
    <div class="navbar__desktop">
        <a href="./home.php#home" class="navbar__desktop-logo">transferspot</a>
        <a href="./home.php#stats" class="navbar__desktop-item">statystyki</a>
        <a href="./home.php#announcements" class="navbar__desktop-item">ogłoszenia</a>
        <a href="./home.php#categories" class="navbar__desktop-item">kategorie</a>
        <?php 
            if ($userId !== '') {
                echo "<a href='dashboard.php' class='navbar__desktop-item'>panel użytkownika</a>
                <a href='../components/user_logout.php' class='navbar__desktop-item'>wyloguj się</a>";
            } else {
                echo '<a href="user_login.php" class="navbar__desktop-item">zaloguj się</a>
                <a href="user_register.php" class="navbar__desktop-item">zarejestruj się</a>';
            };
        ?>
    </div>
</nav>