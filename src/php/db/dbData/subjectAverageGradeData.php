<?php
header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=localhost;dbname=monitoring", 'root', '12345678'); #Подключение к БД
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
}

$stmt = $pdo->prepare('
SELECT 
    groups.name AS group_name, 
    AVG(grades.grade) AS average_grade
FROM 
    grades
JOIN 
    students ON grades.student_id = students.id
JOIN 
    `groups` ON students.group_id = groups.id
JOIN 
    subjects ON grades.subject_id = subjects.id
WHERE 
    subjects.name = :subject_name
GROUP BY 
    groups.name
ORDER BY 
    average_grade DESC;
');

$stmt->execute([
    'subject_name' => 'Литература (Рудакова Л.В.)'
]);
$res = $stmt->fetchAll();

$data = [];
foreach ($res as $row) {
    $data[] = [$row['group_name'], round((float)$row['average_grade'], 2)];
}

echo json_encode($data);
