<?php
function generateGradeRatioChart($subjectName)
{
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
        subjects.name = :subject_name
    GROUP BY
        `groups`.id
    ORDER BY 
        grade_5 DESC;
    ');

    $stmt->execute([
        'subject_name' => $subjectName
    ]);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $grades = [
        ['5'],
        ['4'],
        ['3'],
        ['2']
    ];

    foreach ($res as $row) {
        $grades[0][] = $row['grade_5'];
        $grades[1][] = $row['grade_4'];
        $grades[2][] = $row['grade_3'];
        $grades[3][] = $row['grade_2'];
    }
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            c3.generate({
                bindto: '#subject-grade-ratio',
                title: {
                    text: 'Соотношение оценок предмета'
                },
                data: {
                    columns: <?= json_encode($grades)?>,
                    type: 'donut',
                    order: null
                },
                legend: {
                    position: 'right'
                },
                size: {
                    width: 380
                },
                color: {
                    pattern: ['#7abd7e', '#b9ca77', '#F8D66F', '#ff6961']
                },
                transition: {
                    duration: 1000
                }
            });
        });

    </script>
<?php
}
