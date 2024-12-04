<?php
header('Content-Type: application/json');

// Пример данных
$data = [
    ['Category 1', 20],
    ['Category 2', 40],
    ['Category 3', 60]
];

echo json_encode($data);
