<link rel="stylesheet" href="../../styles/groupPage.css">
<?php
require '../db/dbConnect.php';
require 'elements/getGroupInfo.php';
require 'elements/groupGradeRatio.php';
require 'elements/subjectsGradeRatio.php';
require 'elements/qualityPerformance.php';
require 'elements/attendanceRate.php';
?>
<style>

</style>
<p><?= getMonitoringName(); ?></p>
<div class="menu">
    <form method="post">
        <select name="group" onchange="this.form.submit()">
            <option>--Выберите группу--</option>
            <?php

            global $pdo, $averageGrade, $absolutePerformance, $qualityPerformance, $studentCount;

            $selectedOption = isset($_POST['group']) ? $_POST['group'] : NULL;

            $stmt = $pdo->query('SELECT name FROM `groups`');

            while ($group = $stmt->fetch()):
                ?>
                <option <?php if($selectedOption == $group['name']) echo 'selected' ?>>
                    <?= $group['name'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>
</div>
<div class="charts">
    <div class="top-info">
        <div class="top-left-info">
            <div class="info" id="group-info">
                <div class="info-container">
                    <p class="label">Информация по группе:</p>
                    <p class="value"><?= $selectedOption ?></p>
                    <div class="black"></div>
                </div>
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
                    <p>Количество студентов:</p>
                    <p class="value"><?= $studentCount ?></p>
                    <div class="black"></div>
                </div>
            </div>
            <div id="group-grade-ratio">
                <?php
                if (!empty($selectedOption)) {
                    generateGroupGradeRatioChart($selectedOption);
                }
                ?>
            </div>
        </div>
        <div id="quality-performance">
            <?php
            if (!empty($selectedOption)) {
                generateQualityPerformance($selectedOption);
            }
            ?>
        </div>
    </div>
    <div class="bottom-info">
        <div id="subjects-grade-ratio">
            <?php
            if (!empty($selectedOption)) {
                generateSubjectsGradeRatio($selectedOption);
            }
            ?>
        </div>
        <div id="attendance-rate">
            <?php
            if (!empty($selectedOption)) {
                generateAttendanceRate($selectedOption);
            }
            ?>
        </div>
    </div>
</div>
