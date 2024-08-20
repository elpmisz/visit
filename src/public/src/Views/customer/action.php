<?php
session_start();
ini_set("display_errors", 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
include_once(__DIR__ . "/../../../vendor/autoload.php");

use App\Classes\Validation;
use App\Classes\Visit;

$VISIT = new Visit();
$VALIDATION = new Validation();

$param = (isset($params) ? explode("/", $params) : header("Location: /error"));
$action = (isset($param[0]) ? $param[0] : die(header("Location: /error")));
$param1 = (isset($param[1]) ? $param[1] : "");
$param2 = (isset($param[2]) ? $param[2] : "");

if ($action === "create") {
  try {
    $user = (isset($_POST['user']) ? $_POST['user'] : "");
    $name = (isset($_POST['name']) ? $_POST['name'] : "");
    $contact = (isset($_POST['contact']) ? $_POST['contact'] : "");
    $project = (isset($_POST['project']) ? $_POST['project'] : "");

    $VISIT->customer_create([$user, $name, $contact, $project]);

    $VALIDATION->alert("success", "ดำเนินการเรียบร้อย!", "/customer");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "update") {
  try {
    $id = (isset($_POST['id']) ? $_POST['id'] : "");
    $uuid = (isset($_POST['uuid']) ? $_POST['uuid'] : "");
    $user = (isset($_POST['user']) ? $_POST['user'] : "");
    $name = (isset($_POST['name']) ? $_POST['name'] : "");
    $contact = (isset($_POST['contact']) ? $_POST['contact'] : "");
    $project = (isset($_POST['project']) ? $_POST['project'] : "");

    $VISIT->customer_update([$user, $name, $contact, $project, $id]);

    $VALIDATION->alert("success", "ดำเนินการเรียบร้อย!", "/customer");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}


if ($action === "customer-data") {
  try {
    $result = $VISIT->customer_data();
    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}
