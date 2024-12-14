<?php
function generateAveradeGradeChart($subjectName)
{
    global $pdo;

    $stmt = $pdo->prepare('
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
    WHERE 
        subjects.name = :subject_name
    GROUP BY 
        groups.name
    ORDER BY 
        average_grade DESC;
    ');

    $stmt->execute([
        'subject_name' => $subjectName
    ]);
    $res = $stmt->fetchAll();

    $groups = [];
    $averageGrades = [''];
    foreach ($res as $row) {
        $groups[] = $row['group_name'];
        $averageGrades[] = round($row['average_grade'], 2);
    }
?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            c3.generate({
                bindto: '#average-grade',
                title: {
                    text: 'Средний балл по группам'
                },
                data: {
                    columns: [
                        <?= json_encode($averageGrades) ?>
                    ],
                    type: 'bar',
                    color: function (color, d) {
                        if (d && d.value) {
                            if (d.value > 4) {
                                return '#7abd7e';
                            } else if (d.value > 3.75) {
                                return '#B9CA77';
                            } else if (d.value > 3.5) {
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
                legend: {
                    show: false
                },
                padding: {
                    left: 90,
                    bottom: 20
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
                    },
                    y: {
                        show: false
                    }
                },
                bar: {
                    space: 0.5,
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
