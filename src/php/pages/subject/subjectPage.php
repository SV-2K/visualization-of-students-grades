<link rel="stylesheet"  href="../../styles/subjectPage.css">
<p>some_file_name.xlsx</p>
<div class="menu">
    <form method="post">
        <select name="subject" onchange="this.form.submit()">
            <option>--Выберите предмет--</option>
            <?php
            require '../db/dbConnect.php';
            require 'elements/getSubjectInfo.php';
            require 'elements/averageGrade.php';
            require 'elements/subjectGradeRatio.php';
            require 'elements/groupsGradeRatio.php';

            global $pdo, $selectedOption, $averageGrade, $absolutePerformance,
                   $qualityPerformance, $groupsCount, $studentsCount;

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
        <div class="info">
            <div class="info-container">
                <p class="label">Информация по предмету:</p>
                <div class="black"></div>
            </div>
            <p class="subject-name"><?= $selectedOption ?></p>
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