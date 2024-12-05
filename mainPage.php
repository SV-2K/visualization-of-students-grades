<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/mainPage.css">
    <link rel="stylesheet" href="node_modules/c3/c3.min.css">
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
                <select name="subjects">
                    <?php
                    require 'dbConnect.php';
                    global $pdo;

                    $stmt = $pdo->query('SELECT name FROM subjects');

                    while ($subject = $stmt->fetch()):
                    ?>
                    <option>
                        <?= $subject['name'] ?>
                    </option>
                    <?php endwhile; ?>
                </select>
            </form>
        </div>
        <div class="charts">
            <div class="top-info">
                <div id="group-info">Something in here</div>
                <div id="average-grade"></div>
            </div>
            <div class="bottom-info">
                <div id="groups-grade-ratio"></div>
                <div id="subject-grade-ratio"></div>
            </div>
        </div>
    </main>
    <script src="node_modules/c3/node_modules/d3/dist/d3.min.js"></script>
    <script src="node_modules/c3/c3.min.js"></script>
    <script src="jsGraphics/subjectAverageGrade.js"></script>
    <script src="jsGraphics/subjectGroupsGradeRatio.js"></script>
    <script src="jsGraphics/subjectGradeRatio.js"
</body>
</html>