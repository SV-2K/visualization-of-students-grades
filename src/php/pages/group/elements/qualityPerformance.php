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
    ');

    $stmt->execute([
        'group_name' => $groupName
    ]);
    $res = $stmt->fetchAll();

    $performance = [];

    foreach ($res as $key => $row) {
        $performance[$key][] = $row['subject_name'];
        $performance[$key][] = $row['quality_performance'];
    }
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            c3.generate({
                bindto: '#absolute-performance',
                data: {
                    columns: <?= json_encode($performance)?>,
                    type: 'bar',
                    groups: [
                        ['5', '4', '3', '2']
                    ],
                    order: null
                },
                axis: {
                    rotated: true,
                },

                transition: {
                    duration: 1000
                }
            });
        });
    </script>
    <?php
}
