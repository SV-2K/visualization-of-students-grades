<?php
function generateSubjectsGradeRatio($groupName)
{
    global $pdo;

    $stmt = $pdo->prepare('
    SELECT 
            subjects.name AS subject_name,
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
        `groups`.name = :subject_name
    GROUP BY
        subjects.id
    ORDER BY 
        grade_5 DESC;
    ');

    $stmt->execute([
        'subject_name' => $groupName
    ]);
    $res = $stmt->fetchAll();

    $subjects = [];
    $grades = [
        ['5'],
        ['4'],
        ['3'],
        ['2']
    ];



    foreach ($res as $row) {
        $subjects[] = $row['subject_name'];
        $grades[0][] = $row['grade_5'];
        $grades[1][] = $row['grade_4'];
        $grades[2][] = $row['grade_3'];
        $grades[3][] = $row['grade_2'];
    }
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            c3.generate({
                bindto: '#subjects-grade-ratio',
                title: {
                    text: 'Соотношение оценок по предметам'
                },
                data: {
                    columns: <?= json_encode($grades)?>,
                    type: 'bar',
                    groups: [
                        ['5', '4', '3', '2']
                    ],
                    order: null
                },
                legend: {
                    position: 'right'
                },
                axis: {
                    rotated: true,
                    x: {
                        show: true,
                        type: 'category',
                        categories: <?= json_encode($subjects) ?>,
                        tick: {
                            multiline: false,
                            multilineMax: 1,
                        }
                    },
                    y: {
                        show: false
                    }
                },
                color: {
                    pattern: ['#7abd7e', '#b9ca77', '#F8D66F', '#ff6961']
                },
                padding: {
                    bottom: 10
                },
                transition: {
                    duration: 1000
                }
            });
        });
    </script>
    <?php
}
