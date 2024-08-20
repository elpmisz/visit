<?php

use App\Classes\Validation;
use App\Classes\Visit;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$VISIT = new Visit();
$VALIDATION = new Validation();
$SPREADSHEET = new Spreadsheet();
$WRITER = new Xlsx($SPREADSHEET);

$result = $VISIT->request_export();

array_walk_recursive($result, "htmldecode");

function htmldecode(&$item, $key)
{
  $item = html_entity_decode($item, ENT_COMPAT, "UTF-8");
}

$columns = ["ผู้ทำรายการ", "วัถตุประสงค์", "ชื่อลูกค้า", "บริษัท", "เบอร์ติดต่อ", "โครงการ", "รายละเอียด", "วันที่"];

$letters = [];
for ($i = "A"; $i != $VALIDATION->letters(COUNT($columns) + 1); $i++) {
  $letters[] = $i;
}

$columns = array_combine($letters, $columns);

ob_start();
$date = date('Ymd');
$filename = $date . "_export.csv";
header("Content-Encoding: UTF-8");
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename={$filename}");
ob_end_clean();

$output = fopen("php://output", "w");
fputs($output, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
fputcsv($output, $columns);

foreach ($result as $data) {
  fputcsv($output, $data);
}

fclose($output);
die();
