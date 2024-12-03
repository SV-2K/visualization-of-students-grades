<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table, th, td {
            border:1px solid black;
        }
    </style>
    <?php
    require 'vendor/autoload.php';
    require 'dbRequests.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;
    ini_set('memory_limit', '512M');  #Увеличение лимита памяти, потому что таблица большая жесть просто

    try {
        $spreadsheet = IOFactory::load('example.xlsx');
        $sheetCount = $spreadsheet->getSheetCount();

        for ($var = 0; $var < $sheetCount; $var++) {

            $sheet = $spreadsheet->getSheet($var);

            $groupName = $sheet->getTitle();
            enterGroup($groupName);
            $groupId = getGroupId($groupName);

            #############################
            $monitoringName = 'Monitoring bla bla bla';
            $monitoringId = getMonitoringId($monitoringName);
            #############################

            $columnStopper = 99; #Столбец, после которого информация не считывается
            $rowStopper = 99;
            $lastCheckedRow = 0;
            $lastCheckedColumn = 0;

            #Определение границ таблицы
            for ($i = 4; $i < $columnStopper; $i++) {
                #Считывает столбец, на котором заканчиваются наименования предметов
                if ($sheet->getCell([$i, 13]) == 'Количество пропусков') {
                    $columnStopper = $i;  #Как только доходит до конца
                    break;
                }
            }
            for ($i = 17; $i < $rowStopper; $i++) {

                #Вычисление последнего ученика группы
                if ($sheet->getCell("C$i") == '' ||
                    $sheet->getCell("A$i") == '') {
                    $rowStopper = $i; #Метка того, что ниже этой строки ничего ползного нету
                    break;
                }
            }

            echo '<table>';


            foreach ($sheet->getRowIterator() as $rowCounter => $row) {
                $columnCounter = 0;

                #Скип всех строк до 17
                if ($rowCounter < 17) continue;
                if ($rowCounter >= $rowStopper) break;

                echo '<tr>';

                $cellIterator = $row->getCellIterator();

                foreach ($cellIterator as $cell) {
                    $columnCounter++;

                    if ($columnCounter < 4) continue;
                    if ($columnCounter >= $columnStopper) break;

                    $subjectName = $sheet->getCell([$columnCounter, 14]);
                    if ($rowCounter === 17) {
                        enterSubject($subjectName);
                    }
                    $subjectId = getSubjectId($subjectName);

                    #Это нужно чтобы студент и посещаемость не заносились в БД после просмотра каждой оценки
                    #то есть, на каждой строке имя студента и его посещаемость заносятся только 1 раз
                    if ($rowCounter > $lastCheckedRow) {
                        $lastCheckedRow = $rowCounter;

                        $student = $sheet->getCell([3, $rowCounter]);
                        enterStudent($student, $groupId);
                        $studentId = getStudentId($student, $groupId);

                        $invalidAbsenceHours = $sheet->getCell([$columnStopper + 2, $rowCounter]);
                        $validAbsenceHours = $sheet->getCell([$columnStopper + 1, $rowCounter]);
                        enterAbsence($invalidAbsenceHours, $validAbsenceHours, $studentId, $monitoringId);

                    }

                    $grade = $cell->getValue();
                    enterGrade($cell, $subjectId, $studentId, $monitoringId);

                    echo '<td>';
                    echo $cell->getValue();
                    echo '</td>';

                }
                echo '</tr>';
            }
            echo '</table>';
            echo '<br>';
        }
    } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
        echo 'Ошибка при чтении файла: ' . $e->getMessage();
    }
    ?>
</head>
<body>

</body>
</html>


