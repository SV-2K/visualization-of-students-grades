<?php
function generateAttendanceRate()
{
    global $pdo;

    $stmt = $pdo->query('
    SELECT
        SUM(attendance.invalid_absence_hours) AS invalid_hours,
        SUM(attendance.valid_absence_hours) AS valid_hours
    FROM
        attendance
    ');

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
                title: {
                    text: 'Пропуски'
                },
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
                color: {
                    pattern: ['#79d200', '#599900']
                },
                axis: {
                    x: {
                        show: true,
                        type: 'category',
                        categories: [' '],
                        tick: {
                            outer: false
                        },
                    },
                    y: {
                        show: false,
                    }
                },
                size: {
                    height: 502
                },
                transition: {
                    duration: 1000
                }
            });
        });
    </script>
    <?php
}
