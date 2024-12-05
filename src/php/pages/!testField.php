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
        'name' => 'Литература (Рудакова Л.В.)'
    ]);
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
