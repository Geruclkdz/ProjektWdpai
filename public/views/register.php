<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="/public/css/style.css">
    <script type="text/javascript" src="/public/js/script.js" defer></script>
    <script type="text/javascript" src="/public/js/location.js" defer></script>
    <title>REGISTER</title>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="/public/img/logo.svg" alt="LOGO">
    </div>
    <div class="login-container">
        <div class=login_or_register>
            <button id="login">LOGIN</button>
            <button id="register" class="selected">REGISTER</button>
        </div>
        <form class="register" action="register" method="POST">
            <div class="messages">
                <?php
                if (isset($messages)) {
                    foreach ($messages as $message) {
                        echo $message;
                    }
                }
                ?>
            </div>
            <input name="email" type="text" placeholder="e-mail">
            <input name="password" type="password" placeholder="password">
            <input name="confirmedPassword" type="password" placeholder="confirm password">
            <input name="username" type="text" placeholder="username">
            <button type="submit">SUBMIT</button>

        </form>
    </div>
</div>
</body>
</html>