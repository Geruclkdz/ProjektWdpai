<?php
$userEmail = $_SESSION['user']['email'];
$userRepository = new UserRepository();
$user = $userRepository->getUser($userEmail);
$userProfilePicture = $user->getProfilePicture();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://kit.fontawesome.com/b8403c894a.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/icon_click.js" defer></script>
    <link rel="stylesheet" type="text/css" href="/public/css/style.css">
    <title>BreakingNotes</title>
</head>
<body>
<div class="base-container">
    <nav>
        <img src="/public/img/logo.svg" alt="LOGO">
        <ul>
            <li>
                <i class="fa-solid fa-book "></i>
            </li>
            <li>
                <i class="fa-solid fa-user selected"></i>
            </li>
            <li>
                <i class="fa-solid fa-trophy"></i>
            </li>
            <li>
                <a class="button" href="<?= $_SESSION['user']['role'] == "admin" ? "/viewForm" : "/sendForm"; ?>">Application form</a>
            </li>
            <li>
                <a class="button" href="/logout"> Log Out </a>
            </li>
        </ul>

    </nav>
    <main>
        <div class="profile">
            <h1>PROFILE</h1>
            <a href="/edit_profile" class="button"><i class="fa-solid fa-gear"></i></i>Edit Profile</a>
            <img src="<?= $user->getProfilePicture() !== NULL ? $user->getProfilePicture() : 'default.jpg'; ?>">
            <p><?php echo $user->getUsername(); ?></p>
            <p><?php echo $user->getEmail(); ?></p>
            <p><?php echo $user->getName(); ?></p>
            <p><?php echo $user->getSurname(); ?></p>
            <p><?php echo $user->getAge(); ?></p>
            <p><?php echo $user->getDescription(); ?></p>
        </div>
    </main>
</div>
</body>
</html>