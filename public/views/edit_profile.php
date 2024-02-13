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
                <a class="button" href="<?= $_SESSION['user']['role'] == "admin" ? "/sendForm" : "/viewForm"; ?>">Application form</a>
            </li>
            <li>
                <a class="button" href="/logout"> Log Out </a>
            </li>
        </ul>

    </nav>
    <main>
        <div class="profile">
            <h1>PROFILE</h1>
            <form action="edit_profile" method="POST" enctype="multipart/form-data">
                <?php
                if (isset($messages)) {
                    foreach ($messages as $message) {
                        echo $message;
                    }
                }
                ?>
                <input type="file" name="file">
                <input name="name" type="text" placeholder="<?= $user->getName() !== NULL ? $user->getName() : 'Name'; ?>" value="<?= $user->getName() !== NULL ? $user->getName() : NULL; ?>">
                <input name="surname" type="text" placeholder="<?= $user->getSurname() !== NULL ? $user->getSurname() : 'Surname'; ?>" value="<?= $user->getSurname() !== NULL ? $user->getSurname() : NULL; ?>">
                <input name="date_of_birth" type="date" value="<?= $user->getDateOfBirth() !== NULL ? $user->getDateOfBirth() : NULL; ?>">
                <textarea name="description" rows = "5" placeholder="<?= $user->getDescription() !== NULL ? $user->getDescription() : 'Description'; ?>"><?= $user->getDescription() !== NULL ? $user->getDescription() : NULL ; ?></textarea>
                <button type="submit">send</button>
            </form>
        </div>
    </main>
</div>
</body>
</html>