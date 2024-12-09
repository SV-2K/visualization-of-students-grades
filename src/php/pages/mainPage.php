<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../styles/mainPage.css">
    <link rel="stylesheet" href="../../styles/charts.css">
    <link rel="stylesheet" href="../../../node_modules/c3/c3.min.css">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="top-menu">
            <a href="?stat=subject" class="header-button2">
                Предмет
            </a>
            <a href="?stat=group" class="header-button">
                Группа
            </a>
            <a href="?stat=department" class="header-button">
                Отделение
            </a>
            <a href="?stat=college" class="header-button">
                Колледж
            </a>
        </div>
    </header>
    <main>
        <?php
        if (isset($_GET['stat'])) {
            switch ($_GET['stat']) {
                case 'subject':
                    require 'subject/subjectPage.php';
                    break;
                case 'group':
                    require 'group/groupPage.php';
                    break;
            }
        } else {
            require 'subject/subjectPage.php';
        }
        ?>
    </main>
    <script src="../../../node_modules/c3/node_modules/d3/dist/d3.min.js"></script>
    <script src="../../../node_modules/c3/c3.min.js"></script>
</body>
</html>