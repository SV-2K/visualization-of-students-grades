document.addEventListener("DOMContentLoaded", function () {
    fetch('dbData/subjectGroupsGradeRatioData.php')
        .then(response => response.json())
        .then(data => {
            c3.generate({
                bindto: '#groups-grade-ratio',
                data: {
                    // columns: data,
                    columns: [
                        ['5', 13, 12, 12, 10, 8],
                        ['4', 7, 8, 8, 7, 10],
                        ['3', 3, 4, 3, 6, 2],
                        ['2', 1, 1, 1, 2, 4]
                    ],
                    type: 'bar'
                },
                legend: {
                    position: 'right'
                },
                axis: {
                    rotated: true,
                    x: {
                        type: 'category',
                        categories: ['9ПР-4.24К', '9ПР-1.24', '9БД-1.24К', '9ПР-3.24', '9ПР-2.24']
                    },
                    y: {
                        tick: {
                            format: d3.format(".2f") // Отображаем числа с двумя знаками после запятой
                        }
                    }
                },
                bar: {
                    space: 0.5,
                    width: {
                        ratio: 0.8
                    }
                },
                transition: {
                    duration: 1000 // Время анимации в миллисекундах (1 секунда)
                }
            });
        })
        .catch(error => console.error('Ошибка загрузки данных:', error));
});
