<?php
use PhpOffice\PhpSpreadsheet\IOFactory;

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['xlsxFile'])) {

    require '../../../vendor/autoload.php';
    require '../db/parserRequests.php';


    ini_set('memory_limit', '256M');  #Увеличение лимита памяти, потому что таблица большая жесть просто

    if ($_FILES['xlsxFile']['error'] === UPLOAD_ERR_OK) {

        $uploadedFile = $_FILES['xlsxFile']['tmp_name'];
        try {

            $fileName = $_FILES['xlsxFile']['name'];
            updateMonitoringName($fileName);
            cleanDB();

            $spreadsheet = IOFactory::load($uploadedFile);
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

                foreach ($sheet->getRowIterator() as $rowCounter => $row) {
                    $columnCounter = 0;

                    #Скип всех строк до 17
                    if ($rowCounter < 17) continue;
                    if ($rowCounter >= $rowStopper) break;

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
                    }
                }
            }
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            echo 'Ошибка при чтении файла: ' . $e->getMessage();
        }
    } else {
        echo 'Ошибка загрузки файла: ' . $_FILES['xlsxFile']['error'];
    }
}
?>