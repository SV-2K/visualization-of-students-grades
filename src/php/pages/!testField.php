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
require '../db/dbConnect.php';
global $pdo;
function generateAveradeGradeChart($subjectName)
{
    global $pdo;

    $stmt = $pdo->prepare('
    SELECT 
        `groups`.name AS group_name, 
        AVG(grades.grade) AS average_grade
    FROM 
        grades
    JOIN 
        students ON grades.student_id = students.id
    JOIN 
        `groups` ON students.group_id = `groups`.id
    JOIN 
        subjects ON grades.subject_id = subjects.id
    WHERE 
        subjects.name = :subject_name
    GROUP BY 
        `groups`.name
    ORDER BY 
        average_grade DESC;
    ');

    $stmt->execute([
        'subject_name' => $subjectName
    ]);
    $res = $stmt->fetchAll();

    $groups = [];
    $averageGrades = [''];
    foreach ($res as $row) {
        $groups[] = $row['group_name'];
        $averageGrades[] = round($row['average_grade'], 2);

    }
    echo '33333';
    print_r($groups);
}
generateAveradeGradeChart('ИЯВПД (Коваленко С.В./Руднев В.А.)');

?>
</body>
</html>
