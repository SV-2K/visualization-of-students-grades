<?php
function generateQualityPerformance($groupName)
{
    global $pdo;

    $stmt = $pdo->prepare('
    SELECT
        subjects.name AS subject_name,
        (SUM(CASE WHEN grades.grade IN (4, 5) THEN 1 ELSE 0 END) * 100.0) / 
        SUM(CASE WHEN grades.grade IN (2, 3, 4, 5) THEN 1 ELSE 0 END) AS quality_performance
    FROM
        grades
    JOIN
        students ON grades.student_id = students.id
    JOIN
        `groups` ON students.group_id = `groups`.id
    JOIN
        subjects ON grades.subject_id = subjects.id
    WHERE
        `groups`.name = :group_name
    GROUP BY
        subjects.name
    ORDER BY
        quality_performance DESC
    ');

    $stmt->execute([
        'group_name' => $groupName
    ]);
    $res = $stmt->fetchAll();

    $subjects = [];
    $performance = [''];

    foreach ($res as $key => $row) {
        $subjects[] = $row['subject_name'];
        $performance[] = round($row['quality_performance'], 2);
    }
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            c3.generate({
                bindto: '#quality-performance',
                title: {
                    text: 'Качественная успеваемость по предметам в %'
                },
                data: {
                    columns: [
                        <?= json_encode($performance)?>
                    ],
                    type: 'bar',
                    order: null,
                    color: function (color, d) {
                        if (d && d.value) {
                            if (d.value > 70) {
                                return '#7abd7e';
                            } else if (d.value > 60) {
                                return '#B9CA77';
                            } else if (d.value > 50) {
                                return '#F8D66F';
                            } else {
                                return '#ff6961';
                            }
                        }
                        return color;
                    },
                    labels: {
                        format: function (v) {
                            return v;
                        }
                    }
                },
                axis: {
                    rotated: true,
                    x: {
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
                legend: {
                    show: false
                },
                padding: {
                    left: 220,
                    bottom: 20
                },
                color: {
                    pattern: ['#79d200']
                },
                transition: {
                    duration: 1000
                }
            });
        });
    </script>
    <?php
}
