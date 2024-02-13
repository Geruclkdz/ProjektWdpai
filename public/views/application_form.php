<?php
$categoryRepository = new CategoryRepository();
$categories = $categoryRepository->getCategories();
$videoRepository = new VideoRepository();
$videos = $videoRepository->getVideos();
?>

<!DOCTYPE html>
<head>
    <script src="https://kit.fontawesome.com/b8403c894a.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/search.js" defer></script>
    <script type="text/javascript" src="./public/js/categories.js" defer></script>
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
                <i class="fa-solid fa-book"></i>
            </li>
            <li>
                <i class="fa-solid fa-user"></i>
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
        <div class="application-form">
            <h1>Send application form</h1>
            <form action="sendForm" method="POST" ENCTYPE="multipart/form-data">
                <?php
                if (isset($messages)) {
                    foreach ($messages as $message) {
                        echo $message;
                    }
                }
                ?>
                <input name="title" type="text" placeholder="title">
                <div class="form_choice">
                    <input name="report_bug" type="checkbox">
                    Report bug
                    </input>
                    <input name="suggest_functionality" type="checkbox">
                    Suggest new functionality
                    </input>
                </div>
                <textarea name="description" rows="5"></textarea>
                <button type="submit">send</button>
            </form>
        </div>

    </main>
</div>

</body>
