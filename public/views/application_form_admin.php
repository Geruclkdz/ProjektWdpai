<?php
$reportRepository = new ReportRepository();
$reports = $reportRepository->getReports();
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
        filterVideos('Footwork');
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
        <div class="application-form">
            <h2>Reports</h2>
            <table>
                <thead>
                <tr>
                    <th>User ID</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?= $report['id_users']; ?></td>
                        <td><?= $report['title']; ?></td>
                        <td><?= $report['type']; ?></td>
                        <td><?= $report['description']; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>


    </main>
</div>

</body>
