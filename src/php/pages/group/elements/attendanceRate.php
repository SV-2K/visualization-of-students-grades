<?php
function generateAttendanceRate($groupName)
{
    global $pdo;

    $stmt = $pdo->prepare('
    SELECT
        SUM(attendance.invalid_absence_hours) AS invalid_hours,
        SUM(attendance.valid_absence_hours) AS valid_hours
    FROM
        attendance
    JOIN
        students ON attendance.student_id = students.id
    JOIN
        `groups` ON students.group_id = `groups`.id
    WHERE
        `groups`.name = :group_name
    ');

    $stmt->execute([
        'group_name' => $groupName
    ]);
    $res = $stmt->fetchAll();
    $attendance = [
        ['Ув', $res[0]['invalid_hours']],
        ['Н/ув', $res[0]['valid_hours']]
    ];

    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            c3.generate({
                bindto: '#attendance-rate',
                data: {
                    columns: <?= json_encode($attendance) ?>,
                    type: 'bar',
                    groups: [
                        ['Ув', 'Н/ув']
                    ],
                    order: null
                },
                bar: {
                    width: 50
                },
                axis: {
                    x: {
                        show: true,
                        type: 'category',
                        categories: [' '],
                        tick: {
                            outer: false
                        }
                    },
                    y: {
                        show: false
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
