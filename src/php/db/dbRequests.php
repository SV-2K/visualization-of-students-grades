<?php

$host = "localhost"; //Если ошибка, то ввести 127.0.0.1
$user = "root";
$password = "12345678";
$dbname = "monitoring";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password); #Подключение к БД
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
}

function getMonitoringId($monitoringName)
{
    global $pdo;

    $stmt = $pdo->prepare('SELECT id FROM monitoring WHERE name = :name');
    $stmt->execute([
        'name' => $monitoringName
    ]);

    $monitoring = $stmt->fetch();

    return $monitoring['id'];
}
function enterGroup($groupName): void
{
    global $pdo;
    #IGNORE это чтобы предмет не заносился, если он уже существует
    #Также из за того что слово groups зарезервировано в MySQL, пришлось обернуть название таблицы в косые кавычки
    $stmt = $pdo->prepare('INSERT IGNORE INTO `groups` (name) VALUES (:name)');
    $stmt->execute([
        'name' => $groupName
    ]);
}
function getGroupId($groupName)
{
    global $pdo;

    $stmt = $pdo->prepare('SELECT id FROM `groups` WHERE name = :name');
    $stmt->execute([
        'name' => $groupName
    ]);
    $group = $stmt->fetch();

    return $group['id'];
}
function enterSubject($subjectName): void
{
    global $pdo;

    #избавляемся от двойных пробелов, ибо потом из за этого статистика по предмету ломается
    $fixedSubjectName = preg_replace('/\s+/', ' ', $subjectName);

    $stmt = $pdo->prepare('INSERT IGNORE INTO subjects (name) VALUES (:name)');
    $stmt->execute([
        'name' => $fixedSubjectName
    ]);
}
function getSubjectId($subjectName)
{
    global $pdo;
    $subjectNameWithNoDoubleSpaces = preg_replace('/\s+/', ' ', $subjectName);

    $stmt = $pdo->prepare('SELECT id FROM subjects WHERE name = :name');
    $stmt->execute([
        'name' => $subjectNameWithNoDoubleSpaces,
    ]);
    $subject = $stmt->fetch();

    return $subject['id'];
}
function enterStudent($studentName, $groupId): void
{
    global $pdo;

    $stmt = $pdo->prepare('INSERT IGNORE INTO students (name, group_id) VALUES (:name, :group_id)');
    $stmt->execute([
        'name' => $studentName,
        'group_id' => $groupId
    ]);
}
function getStudentId($studentName, $groupId)
{
    global $pdo;

    $stmt = $pdo->prepare('SELECT id FROM students WHERE name = :name AND group_id = :group_id');
    $stmt->execute([
        'name' => $studentName,
        'group_id' => $groupId
    ]);
    $student = $stmt->fetch();

    return $student['id'];
}
function enterGrade($grade, $subjectId, $studentId, $monitoringId): void
{
    global $pdo;

    if ($grade != '5' && $grade != '4' && $grade != '3') $grade = 2;

    $stmt = $pdo->prepare('
        INSERT IGNORE INTO grades (monitoring_id, student_id, subject_id, grade) 
        VALUES (:monitoring_id, :student_id, :subject_id, :grade)');
    $stmt->execute([
        'monitoring_id' => $monitoringId,
        'student_id' => $studentId,
        'subject_id' => $subjectId,
        'grade' => $grade
    ]);
}

function enterAbsence($invalidAbsenceHours, $validAbsenceHours, $studentId, $monitoringId) :void
{
    global $pdo;

    $stmt = $pdo->prepare('INSERT IGNORE INTO attendance 
       (monitoring_id, student_id, invalid_absence_hours, valid_absence_hours) VALUES 
       (:monitoring_id, :student_id, :invalid_absence_hours, :valid_absence_hours)');
    $stmt->execute([
        'monitoring_id' => $monitoringId,
        'student_id' => $studentId,
        'invalid_absence_hours' => $invalidAbsenceHours,
        'valid_absence_hours' => $validAbsenceHours
    ]);
}
