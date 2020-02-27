<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
            <?php echo "<img src='./pics/fh-logo.png' id='icon' alt='User Icon' />"; ?>
        </div>

        <!-- Login Form -->
        <form method="post" action="./helper/check_login.php">
            <input name="username" class="fadeIn second" type="text" placeholder="username" required>
            <input name="pwd" class="fadeIn third" type="password" placeholder="password" disabled><br>
            <input type="submit" class="fadeIn fourth" value="Log In">
        </form>

        <?php 
        /* MessageBox, falls $_GET["msg"] vorhanden */
        if(isset($_GET["msg"])){
            if($_GET["msg"] == "falscherUser"){
                echo "<p class='fadeIn fifth'> Dieser User existiert nicht oder falsches Passwort. <p>";    
            }
            if($_GET["msg"] == "logout"){
                echo "<p class='fadeIn fifth'> Sie wurden erfolgreich ausgeloggt. <p>";    
            }

        }
        ?>

    </div>
</div>
