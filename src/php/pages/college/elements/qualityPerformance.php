<?php
function generateQualityPerformance()
{
    global $pdo;

    $stmt = $pdo->query('
    SELECT
        subjects.name AS subject_name,
        (SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100.0) / 
        SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS quality_performance
    FROM
        grades
    JOIN
        students ON grades.student_id = students.id
    JOIN
        subjects ON grades.subject_id = subjects.id
    GROUP BY
        subjects.name
    ORDER BY 
        quality_performance DESC
    ');

    $res = $stmt->fetchAll();

    $performance = [''];
    $subjects = [];

    foreach ($res as $key => $row) {
        $subjects[] = $row['subject_name'];
        $performance[] = round($row['quality_performance'], 2);
    }
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            c3.generate({
                bindto: '#subjects-quality-performance',
                title: {
                    text: 'Качественная успеваемость по предметам'
                },
                data: {
                    columns: [
                        <?= json_encode($performance) ?>
                    ],
                    type: 'bar',
                    order: null
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
                    }
                },
                size: {
                    height: 1007
                },
                color: {
                    pattern: ['#79d200']
                },
                legend: {
                    show: false
                },
                transition: {
                    duration: 1000
                }
            });
        });
    </script>
    <?php
}
