<?php
function generateGroupsGradeRatioChart($subjectName)
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
    $groups = [];

    foreach ($res as $row) {
        $groups[] = $row['group_name'];
        $grades[0][] = $row['grade_5'];
        $grades[1][] = $row['grade_4'];
        $grades[2][] = $row['grade_3'];
        $grades[3][] = $row['grade_2'];
    }
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            c3.generate({
                bindto: '#groups-grade-ratio',
                data: {
                    columns: <?= json_encode($grades) ?>,
                    // columns: [
                    //     ['5', 13, 12, 12, 10, 8],
                    //     ['4', 7, 8, 8, 7, 10],
                    //     ['3', 3, 4, 3, 6, 2],
                    //     ['2', 1, 1, 1, 2, 4]
                    // ],
                    type: 'bar'
                },
                legend: {
                    position: 'right'
                },
                axis: {
                    rotated: true,
                    x: {
                        type: 'category',
                        categories: <?= json_encode($groups) ?>
                    },
                },
                bar: {
                    space: 0.5,
                    width: {
                        ratio: 0.8
                    }
                },
                transition: {
                    duration: 1000
                }
            });
        });
    </script>
    <?php
}
