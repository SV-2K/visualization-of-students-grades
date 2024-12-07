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
            <div class="header-button2">Предмет</div>
            <div class="header-button">Группа</div>
            <div class="header-button">Отделение</div>
            <div class="header-button">Колледж</div>
        </div>
    </header>
    <main>
        <p>some_file_name.xlsx</p>
        <div class="menu">
            <form method="post">
                <select name="subject" onchange="this.form.submit()">
                    <?php
                    require '../db/dbConnect.php';
                    require 'mainPageLogic.php';
                    require '../graphics/subject/averageGrade.php';
                    require '../graphics/subject/subjectGradeRatio.php';
                    require '../graphics/subject/groupsGradeRatio.php';

                    global $pdo, $selectedOption, $averageGrade, $subjectName, $absolutePerformance,
                           $qualityPerformance, $groupsCount, $studentsCount;

                    $subjectName = $_POST['subject'];
                    $selectedOption = isset($_POST['subject']) ? $_POST['subject'] : NULL;

                    $stmt = $pdo->query('SELECT name FROM subjects');

                    while ($subject = $stmt->fetch()):
                    ?>
                    <option <?php if($selectedOption == $subject['name']) echo 'selected' ?>>
                        <?= $subject['name'] ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </form>
        </div>
        <div class="charts">
            <div class="top-info">
                <div class="group-info">
                    <div class="info-container">
                        <p class="label">Информация по предмету:</p>
                        <div class="black"></div>
                    </div>
                    <p class="subject-name"><?= $subjectName ?></p>
                    <div class="info-container">
                        <p>Средний балл:</p>
                        <p class="value"><?= $averageGrade ?></p>
                        <div class="black"></div>
                    </div>
                    <div class="info-container">
                        <p>Абсолютная успеваемость:</p>
                        <p class="value"><?= $absolutePerformance ?></p>
                        <div class="black"></div>
                    </div>
                    <div class="info-container">
                        <p>Качественная успеваемость:</p>
                        <p class="value"><?= $qualityPerformance ?></p>
                        <div class="black"></div>
                    </div>
                    <div class="info-container small-text">
                        <p>Количество групп:</p>
                        <p class="value"><?= $groupsCount ?></p>
                        <div class="black"></div>
                    </div>
                    <div class="info-container small-text">
                        <p>Количество студентов:</p>
                        <p class="value"><?= $studentsCount ?></p>
                        <div class="black"></div>
                    </div>
                    <div class="black"></div>
                </div>
                <div id="average-grade">
                    <?php
                    if (!empty($selectedOption)) {
                        generateAveradeGradeChart($selectedOption);
                    }
                    ?>
                </div>
            </div>
            <div class="bottom-info">
                <div id="groups-grade-ratio">
                    <?php
                    if (!empty($selectedOption)) {
                        generateGroupsGradeRatioChart($selectedOption);
                    }
                    ?>
                </div>
                <div id="subject-grade-ratio">
                    <?php
                    if (!empty($selectedOption)) {
                        generateGradeRatioChart($selectedOption);
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <script src="../../../node_modules/c3/node_modules/d3/dist/d3.min.js"></script>
    <script src="../../../node_modules/c3/c3.min.js"></script>
</body>
</html>