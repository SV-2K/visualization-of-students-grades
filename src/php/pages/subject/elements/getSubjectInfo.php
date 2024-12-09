<?php

if (isset($_POST['subject'])) {
    $subjectName = $_POST['subject'];

    $averageGrade = calculateAverageGrade($subjectName);
    $absolutePerformance = calculateAbsolutePerformance($subjectName);
    $qualityPerformance = calculateQualityPerformance($subjectName);
    $groupsCount = calculateGroupsCount($subjectName);
    $studentsCount = calculateStudentsCount($subjectName);
}

function calculateAverageGrade($subjectName)
{
    global $pdo;

    $stmt = $pdo->prepare('
    SELECT
        AVG(grades.grade) AS average_grade
    FROM
        grades
    JOIN
        subjects ON grades.subject_id = subjects.id
    WHERE
        subjects.name = :name
    ');
    $stmt->execute([
        'name' => $subjectName
    ]);

    $res = $stmt->fetch();
    $averageGrade = empty($res['average_grade']) ? '???' : round($res['average_grade'], 2);

    return $averageGrade;
}
function calculateAbsolutePerformance($subjectName)
{
    global $pdo;

    $stmt = $pdo->prepare('
        SELECT
        (SUM(CASE WHEN grades.grade IN (3, 4, 5) THEN 1 ELSE 0 END) * 100.0) / 
        SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS absolute_performance
    FROM
        grades
    JOIN
        subjects ON grades.subject_id = subjects.id
    WHERE
        subjects.name = :name
    ');
    $stmt->execute([
        'name' => $subjectName
    ]);
    $res = $stmt->fetch();
    $absolutePerformance = empty($res['absolute_performance']) ? '???' : round($res['absolute_performance'], 2) . '%';

    return $absolutePerformance;
}
function calculateQualityPerformance($subjectName)
{
    global $pdo;

    $stmt = $pdo->prepare('
        SELECT
        (SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100.0) / 
        SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS absolute_performance
    FROM
        grades
    JOIN
        subjects ON grades.subject_id = subjects.id
    WHERE
        subjects.name = :name
    ');
    $stmt->execute([
        'name' => $subjectName
    ]);
    $res = $stmt->fetch();
    $qualityPerformance = empty($res['absolute_performance']) ? '???' : round($res['absolute_performance'], 2) . '%';

    return $qualityPerformance;
}
function calculateGroupsCount($subjectName)
{
    global $pdo;

    $stmt = $pdo->prepare('
    SELECT
        COUNT(DISTINCT `groups`.id) AS groups_count
    FROM
        grades
    JOIN
        students ON grades.student_id = students.id
    JOIN
        subjects ON grades.subject_id = subjects.id
    JOIN
        `groups` ON students.group_id = groups.id
    WHERE
        subjects.name = :name
    ');
    $stmt->execute([
        'name' => $subjectName
    ]);
    $res = $stmt->fetch();
    $groupsCount = empty($res['groups_count']) ? '???' : $res['groups_count'];

    return $groupsCount;
}
function calculateStudentsCount($subjectName)
{
    global $pdo;

    $stmt = $pdo->prepare('
    SELECT
        COUNT(students.name) AS students_count
    FROM
        grades
    JOIN
        students ON grades.student_id = students.id
    JOIN
        subjects ON grades.subject_id = subjects.id
    WHERE
        subjects.name = :name
    ');
    $stmt->execute([
        'name' => $subjectName
    ]);
    $res = $stmt->fetch();
    $studentCount = empty($res['students_count']) ? '???' : $res['students_count'];

    return $studentCount;
}