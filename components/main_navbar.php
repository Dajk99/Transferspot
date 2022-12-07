<nav class="navbar">
    <!-- MOBILE -->
    <div class="navbar__mobile">
        <div class="navbar__mobile-btns">
            <button class="navbar__mobile-btns-btn" onclick="location.href='#home'"><i class="fa-solid fa-house"></i></button>
            <button class="navbar__mobile-btns-btn navbar__mobile-btns-btn-burger"><i class="fa-solid fa-bars"></i></button>
        </div>
        <a href="dashboard.php" class="navbar__mobile-item deactive">panel użytkownika</a>
        <a href="#announcements" class="navbar__mobile-item deactive">ogłoszenia</a>
        <?php 
            if (isset($userId)) {
                echo '<a href="user_register.php" class="navbar__mobile-item deactive">zarejestruj się</a>
                <a href="user_login.php" class="navbar__mobile-item deactive">przełącz konto</a>
                <a href="#" class="navbar__mobile-item deactive">wyloguj się</a>';
            } else {
                echo '<a href="user_login.php" class="navbar__mobile-item deactive">zaloguj się</a>
                <a href="user_register.php" class="navbar__mobile-item deactive">zarejestruj się</a>';
            };
        ?>
    </div>
    <!-- DESKTOP -->
    <div class="navbar__desktop">
        <a href="#home" class="navbar__desktop-logo">transferspot</a>
        <a href="dashboard.php" class="navbar__desktop-item">panel użytkownika</a>
        <a href="#announcements" class="navbar__desktop-item">ogłoszenia</a>
        <?php 
            if (isset($userId)) {
                echo "<a href='user_register.php' class='navbar__desktop-item'>zarejestruj się</a>
                <a href='user_login.php' class='navbar__desktop-item'>przełącz konto</a>
                <a href='../components/user_logout.php' class='navbar__desktop-item'>wyloguj się</a>";
            } else {
                echo '<a href="user_login.php" class="navbar__desktop-item">zaloguj się</a>
                <a href="user_register.php" class="navbar__desktop-item">zarejestruj się</a>';
            };
        ?>
        <!-- <button class="navbar__desktop-option" onclick="location.href='#home'"><i class="fa-solid fa-user"></i></button> -->
    </div>
</nav>