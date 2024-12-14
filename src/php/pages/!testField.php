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
     UPDATE
        monitoring
    SET 
        name = :monitoring_name
    WHERE
        id = 1;
    ');
    $stmt->execute([
        'monitoring_name' => $subjectName
    ]);
}
generateAveradeGradeChart('ИЯВПД (Коваленко С.В./Руднев В.А.)');

?>
</body>
</html>
