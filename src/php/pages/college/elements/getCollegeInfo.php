<?php
$averageGrade = calculateAverageGrade();
$absolutePerformance = calculateAbsolutePerformance();
$qualityPerformance = calculateQualityPerformance();
$groupsCount = calculateGroupsCount();
$studentsCount = calculateStudentsCount();

function calculateAverageGrade()
{
    global $pdo;

    $stmt = $pdo->query('
    SELECT
        AVG(grades.grade) AS average_grade
    FROM
        grades
    ');
    $college = $stmt->fetch();

    return round($college['average_grade'],2);
}
function calculateAbsolutePerformance()
{
    global $pdo;

    $stmt = $pdo->query('
    SELECT
        SUM(CASE WHEN grades.grade IN (3, 4, 5) THEN 1 ELSE 0 END) * 100 /
        SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS absolute_performance
    FROM
        grades
    ');
    $college = $stmt->fetch();

    return round($college['absolute_performance'], 2) . '%';
}
function calculateQualityPerformance()
{
    global $pdo;

    $stmt = $pdo->query('
    SELECT
        SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100 /
        SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS quality_performance
    FROM
        grades
    ');
    $college = $stmt->fetch();

    return round($college['quality_performance'], 2) . '%';
}
function calculateGroupsCount()
{
    global $pdo;

    $stmt = $pdo->query('
    SELECT
        COUNT(`groups`.name) AS groups_count
    FROM
        `groups`
    ');
    $college = $stmt->fetch();

    return $college['groups_count'];
}
function calculateStudentsCount()
{
    global $pdo;

    $stmt = $pdo->query('
    SELECT
        COUNT(students.name) AS students_count
    FROM
        students
    ');
    $college = $stmt->fetch();

    return $college['students_count'];
}