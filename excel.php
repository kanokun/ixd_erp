<?php
include_once 'vendor/phpexcel/Classes/PHPExcel.php';

$filepath = "vendor/phpexcel/매출-샘플.xlsx";

$filetype = PHPExcel_IOFactory::identify($filepath);
$reader = PHPExcel_IOFactory::createReader($filetype);
$php_excel = $reader->load($filepath);

$sheet = $php_excel->getSheet(0);           // 첫번째 시트
$maxRow = $sheet->getHighestRow();          // 마지막 라인
$maxColumn = $sheet->getHighestColumn();    // 마지막 칼럼

$target = "A"."1".":"."$maxColumn"."$maxRow";
$lines = $sheet->rangeToArray($target, NULL, TRUE, FALSE);

// 라인수 만큼 루프
foreach ($lines as $key => $line) {
    $col = 0;
    $item = array(
        "A"=>$line[$col++],   // 첫번째 칼럼
        "B"=>$line[$col++],   // 두번쨰 칼럼
    );
    
    print_r($item["A"] .",". $item["B"] ."<br/>");
}
?>