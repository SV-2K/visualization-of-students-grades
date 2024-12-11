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

    $averageGrades = [''];
    $groups = [];
    foreach ($res as $row) {
        $groups[] = $row['group_name'];
        $averageGrades[] = round((float)$row['average_grade'], 2);
    }
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            c3.generate({
                bindto: '#groups-average-grade',
                title: {
                    text: 'Средний балл по группам'
                },
                data: {
                    columns: [
                        <?= json_encode($averageGrades) ?>
                    ],
                    type: 'bar'
                },
                legend: {
                    show: false
                },
                padding: {
                    left: 90
                },
                axis: {
                    rotated: true,
                    x: {
                        type: 'category',
                        categories: <?= json_encode($groups) ?>,
                        tick: {
                            multiline: false,
                            multilineMax: 1,
                        }
                    }
                },
                bar: {
                    space: 0.25,
                    width: {
                        ratio: 0.9
                    }
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
