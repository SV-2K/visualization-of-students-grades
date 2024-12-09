<?php
global $pdo;

if (isset($_POST['group'])) {
    $groupName = $_POST['group'];

    $averageGrade = calculateAverageGrade($groupName);
    $absolutePerformance = calculateAbsolutePerformance($groupName);
    $qualityPerformance = calculateQualityPerformance($groupName);
    $studentCount = calculateStudentsCount($groupName);
}
function calculateAverageGrade($groupName)
{
    global $pdo;

    $stmt = $pdo->prepare('
    SELECT
        AVG(grades.grade) as average_grade
    FROM
        grades
    JOIN
        students ON grades.student_id = students.id
    JOIN
        `groups` ON students.group_id = `groups`.id
    WHERE
        `groups`.name = :group_name
    ');
    $stmt->execute([
        'group_name' => $groupName
    ]);
    $group = $stmt->fetch();

    return round($group['average_grade'], 2);
}
function calculateAbsolutePerformance($groupName)
{
    global $pdo;

    $stmt = $pdo->prepare('
    SELECT
        SUM(CASE WHEN grades.grade IN (3, 4, 5) THEN 1 ELSE 0 END) * 100 /
        SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS absolute_performance
    FROM
        grades
    JOIN
        students ON grades.student_id = students.id
    JOIN
        `groups` ON students.group_id = `groups`.id
    WHERE
        `groups`.name = :group_name
    ');
    $stmt->execute([
        'group_name' => $groupName
    ]);
    $group = $stmt->fetch();

    return round($group['absolute_performance'], 2) . '%';
}
function calculateQualityPerformance($groupName)
{
    global $pdo;

    $stmt = $pdo->prepare('
    SELECT
        SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100 /
        SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS quality_performance
    FROM
        grades
    JOIN
        students ON grades.student_id = students.id
    JOIN
        `groups` ON students.group_id = `groups`.id
    WHERE
        `groups`.name = :group_name
    ');
    $stmt->execute([
        'group_name' => $groupName
    ]);
    $group = $stmt->fetch();

    return round($group['quality_performance'], 2) . '%';
}
function calculateStudentsCount($groupName)
{
    global $pdo;

    $stmt = $pdo->prepare('
    SELECT
        COUNT(students.name) AS student_count
    FROM
        students
    JOIN
        `groups` ON students.group_id = `groups`.id
    WHERE
        `groups`.name = :group_name
    ');
    $stmt->execute([
        'group_name' => $groupName
    ]);
    $group = $stmt->fetch();

    return $group['student_count'];
}