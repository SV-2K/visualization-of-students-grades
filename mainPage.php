<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles/mainPage.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div class="top-menu">
            <div class="header-button">Предмет</div>
            <div class="header-button">Группа</div>
            <div class="header-button">Отделение</div>
            <div class="header-button2">Колледж</div>
        </div>
    </header>
    <main>
        <p>some_file_name.xlsx</p>
        <div class="menu">
            <!--       -->
        </div>
        <div class="charts">
            <div class="top-info">
                <div id="group-info">Some bullshit in here</div>
                <div id="average-grade"></div>
            </div>
            <div class="bottom-info">
                <div id="groups-grade-ratio"></div>
                <div id="subject-grade-ratio"></div>
            </div>
        </div>
    </main>
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/c3/c3.min.js"></script>
    <script src="test/doughnut-chart.js"></script>
</body>
</html>