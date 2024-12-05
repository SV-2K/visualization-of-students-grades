<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
require 'dbRequests.php';
global $pdo;

$stmt = $pdo->prepare('
SELECT 
        `groups`.name AS group_name,
        SUM(CASE WHEN grades.grade = 5 THEN 1 ELSE 0 END) AS grade_5,
        SUM(CASE WHEN grades.grade = 4 THEN 1 ELSE 0 END) AS grade_4,
        SUM(CASE WHEN grades.grade = 3 THEN 1 ELSE 0 END) AS grade_3,
        SUM(CASE WHEN grades.grade = 2 THEN 1 ELSE 0 END) AS grade_2
FROM
    grades
JOIN
    students ON grades.student_id = students.id
JOIN
    `groups` ON students.group_id = `groups`.id
JOIN
    subjects ON grades.subject_id = subjects.id
WHERE
    subjects.name = "Литература (Рудакова Л.В.)"
GROUP BY
    `groups`.id
ORDER BY 
    grade_5 DESC;
');

$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

$grades = [
    ['5'],
    ['4'],
    ['3'],
    ['2']
];
$groups = [];

foreach ($res as $row) {
    $groups[] = $row['group_name'];
    $grades[0][] = $row['grade_5'];
    $grades[1][] = $row['grade_4'];
    $grades[2][] = $row['grade_3'];
    $grades[3][] = $row['grade_2'];
}

echo '<pre>';

print_r($grades);

echo '</pre>';
?>
</body>
</html>
