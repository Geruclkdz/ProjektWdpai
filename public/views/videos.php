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
<script>
    function callFilterVideos() {
        // Call filterVideos with an empty string to display all videos initially
        filterVideos('');
    }
</script>

<script>
    // Call the function after categories.js has been loaded
    callFilterVideos();
</script>
<body>
<div class="base-container">
    <nav>
        <img src="/public/img/logo.svg" alt="LOGO">
        <ul>
            <li>
                <i class="fa-solid fa-book selected"></i>
            </li>
            <li>
                <i class="fa-solid fa-user"></i>
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
        <header>
            <div class="search-bar">
                <input placeholder="search video">
            </div>
            <div class="categories">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <button onclick="filterVideos('<?= $category->getName(); ?>')">
                            <?= $category->getName(); ?>
                        </button>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No categories available.</p>
                <?php endif; ?>
                <button id="add_category">
                    <i class="fa-solid fa-square-plus"></i>
                     Add
                </button>

            </div>
            <div class="add-video">
                <a href="/addVideo" class="button"> <i class="fa-solid fa-square-plus"></i> Add video</a>
            </div>
        </header>
        <section class="videos">
            <?php foreach ($videos as $video): ?>
                <div class="video" id="<?= $video->getId(); ?>">
                    <div class="video_top">
                        <h2><?= $video->getTitle(); ?></h2>
                        <div class="custom-dropdown">
                            <button class="dropdown-btn">+</button>
                            <div class="dropdown-content">
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <label>
                                            <?php $isChecked = in_array($category, $video->getCategories()); ?>

                                            <input type="checkbox"
                                                   id="<?= $category->getId(); ?>" <?= $isChecked ? 'checked' : ''; ?>>
                                            <?= $category->getName(); ?>
                                        </label>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No categories available.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <video controls preload="metadata">
                        <source src="<?= $video->getVideo(); ?>#t=5" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
</div>

</body>

<template id="video_template">
    <div class="video" id="">
        <div class="video_top">
            <h2>title</h2>
        </div>
        <video controls preload="metadata">
            <source src="" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</template>
