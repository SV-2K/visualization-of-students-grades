<?php
function generateAveradeGrade()
{
    global $pdo;

    $stmt = $pdo->query('
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
    GROUP BY 
        groups.name
    ORDER BY 
        average_grade DESC;
    ');
    $res = $stmt->fetchAll();

    $data = [];
    foreach ($res as $row) {
        $data[] = [$row['group_name'], round((float)$row['average_grade'], 2)];
    }
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            c3.generate({
                bindto: '#groups-average-grade',
                data: {
                    columns: <?= json_encode($data) ?>,
                    type: 'bar'
                },
                legend: {
                    position: 'right'
                },
                axis: {
                    rotated: true,
                },
                bar: {
                    space: 0.25,
                    width: {
                        ratio: 0.9
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
