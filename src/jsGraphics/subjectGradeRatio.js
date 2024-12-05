document.addEventListener("DOMContentLoaded", function () {
    fetch('../db/dbData/subjectGradeRatioData.php')
        .then(response => response.json())
        .then(data => {
            c3.generate({
                bindto: '#subject-grade-ratio',
                data: {
                    columns: data.grades,
                    // columns: [
                    //     ['5', 13, 12, 12, 10, 8],
                    //     ['4', 7, 8, 8, 7, 10],
                    //     ['3', 3, 4, 3, 6, 2],
                    //     ['2', 1, 1, 1, 2, 4]
                    // ],
                    type: 'donut'
                },
                legend: {
                    position: 'right'
                },
                size: {
                    width: 380
                },
                transition: {
                    duration: 1000 // Время анимации в миллисекундах (1 секунда)
                }
            });
        })
        .catch(error => console.error('Ошибка загрузки данных:', error));
});
