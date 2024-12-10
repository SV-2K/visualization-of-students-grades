<?php
function generateGradeRatio()
{
    global $pdo;

    $stmt = $pdo->query('
    SELECT 
            SUM(CASE WHEN grades.grade = 5 THEN 1 ELSE 0 END) AS grade_5,
            SUM(CASE WHEN grades.grade = 4 THEN 1 ELSE 0 END) AS grade_4,
            SUM(CASE WHEN grades.grade = 3 THEN 1 ELSE 0 END) AS grade_3,
            SUM(CASE WHEN grades.grade = 2 THEN 1 ELSE 0 END) AS grade_2
    FROM
        grades
    ORDER BY 
        grade_5 DESC;
    ');

    $res = $stmt->fetchAll();

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
                bindto: '#grade-ratio',
                data: {
                    columns: <?= json_encode($grades)?>,
                    type: 'donut'
                },
                legend: {
                    position: 'right'
                },
                size: {
                    width: 380
                },
                transition: {
                    duration: 1000
                }
            });
        });
    </script>
    <?php
}
