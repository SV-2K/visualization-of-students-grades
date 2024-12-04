document.addEventListener("DOMContentLoaded", function () {
    fetch('dbData/subjectAverageGradeData.php')
        .then(response => response.json())
        .then(data => {
            c3.generate({
                bindto: '#average-grade',
                data: {
                    columns: data,
                    type: 'bar'
                },
                legend: {
                    position: 'right'
                },
                axis: {
                    rotated: true,
                    y: {
                        min: 3.5,
                        tick: {
                            format: d3.format(".2f") // Отображаем числа с двумя знаками после запятой
                        }
                    }
                },
                bar: {
                    space: 0.5,
                    width: {
                        ratio: 0.5
                    }
                },
                transition: {
                    duration: 1000 // Время анимации в миллисекундах (1 секунда)
                }
            });
        })
        .catch(error => console.error('Ошибка загрузки данных:', error));
});
