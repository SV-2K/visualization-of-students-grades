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
        COUNT(students.name) AS student_count
    FROM
        students
    JOIN
        `groups` ON students.group_id = `groups`.id
    WHERE
        `groups`.name = :name
    ');

    $stmt->execute([
        'name' => '9ПР-1.22'
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
