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

try {
    $stmt = $pdo->prepare('
    SELECT
        subjects.name AS subject_name,
        (SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100.0) / 
        SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS quality_performance
    FROM
        grades
    JOIN
        students ON grades.student_id = students.id
    JOIN
        subjects ON grades.subject_id = subjects.id
    GROUP BY
        subjects.name
    ');

    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<pre>';
    print_r($res);
    echo '</pre>';
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage());
}

?>
</body>
</html>
