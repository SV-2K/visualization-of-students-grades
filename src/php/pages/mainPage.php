<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../styles/styles.css">
    <link rel="stylesheet" href="../../styles/charts.css">
    <link rel="stylesheet" href="../../../node_modules/c3/c3.min.css">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono&display=swap" rel="stylesheet">
    <title>Document</title>
    <?php if (!isset($_GET['stat'])) $_GET['stat'] = 'group' ?>
</head>
<body>
    <header>
        <div class="top-menu">
            <a href="?stat=group" class="<?php echo $_GET['stat'] == 'group' ? 'header-button-active' : 'header-button'?>">
                Группа
            </a>
            <a href="?stat=department" class="<?php echo $_GET['stat'] == 'department' ? 'header-button-active' : 'header-button'?>">
                Отделение
            </a>
            <a href="?stat=college" class="<?php echo $_GET['stat'] == 'college' ? 'header-button-active' : 'header-button'?>">
                Колледж
            </a>
            <a href="?stat=subject" class="<?php echo $_GET['stat'] == 'subject' ? 'header-button-active' : 'header-button'?>">
                Предмет
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

                case 'college':
                    require 'college/collegePage.php';
                    break;
            }
        } else {
            $_GET['stat'] = 'group';
            require 'group/groupPage.php';
        }
        ?>
    </main>
    <script src="../../../node_modules/c3/node_modules/d3/dist/d3.min.js"></script>
    <script src="../../../node_modules/c3/c3.min.js"></script>
</body>
</html>