<?php
require '../db/dbConnect.php';
require 'elements/getCollegeInfo.php';
require 'elements/attendanceRate.php';
require 'elements/groupsAverageGrade.php';
require 'elements/gradeRatio.php';
require 'elements/qualityPerformance.php';

global $averageGrade, $absolutePerformance, $qualityPerformance, $groupsCount, $studentsCount;
?>
<link rel="stylesheet" href="../../styles/collegePage.css">
<p>some_file_name.xlsx</p>
<div class="charts">
    <div class="left-info">
        <div class="top-info">
            <div class="top-left-info">
                <div class="info">
                    <div class="info-container">
                        <p class="label">Информация по колледжу:</p>
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
                        <p>Количество групп:</p>
                        <p class="value"><?= $groupsCount ?></p>
                        <div class="black"></div>
                    </div>
                    <div class="info-container small-text">
                        <p>Количество студентов:</p>
                        <p class="value"><?= $studentsCount ?></p>
                        <div class="black"></div>
                    </div>
                </div>
                <div id="grade-ratio">
                    <?php generateGradeRatio(); ?>
                </div>
            </div>
            <div id="attendance-rate">
                <?php generateAttendanceRate() ?>
            </div>
        </div>
        <div id="groups-average-grade">
            <?php generateAveradeGrade() ?>
        </div>
    </div>
    <div class="right-info">
        <div id="subjects-quality-performance">
            <?php generateQualityPerformance() ?>
        </div>
    </div>
</div>