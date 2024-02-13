<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="/public/css/style.css">
    <script type="text/javascript" src="/public/js/location.js" defer></script>
    <title>LOGIN</title>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="/public/img/logo.svg" alt="LOGO">
    </div>
    <div class="login-container">
        <div class=login_or_register>
            <button id="login" class="selected">LOGIN</button>
            <button id="register">REGISTER</button>
        </div>
        <form class="login" action="login" method="POST">
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
            <button id="submit" type="submit">SUBMIT</button>
        </form>
    </div>
</div>
</body>
