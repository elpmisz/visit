<?php
session_start();
ini_set("display_errors", 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");
include_once(__DIR__ . "/../../../vendor/autoload.php");

$param = (isset($params) ? explode("/", $params) : header("Location: /error"));
$action = (isset($param[0]) ? $param[0] : die(header("Location: /error")));
$param1 = (isset($param[1]) ? $param[1] : "");
$param2 = (isset($param[2]) ? $param[2] : "");

use App\Classes\Validation;
use App\Classes\Visit;
use App\Classes\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

try {
  define("JWT_SECRET", "SECRET-KEY");
  define("JWT_ALGO", "HS512");
  $jwt = (isset($_COOKIE['jwt']) ? $_COOKIE['jwt'] : "");
  if (empty($jwt)) {
    die(header("Location: /"));
  }
  $decode = JWT::decode($jwt, new Key(JWT_SECRET, JWT_ALGO));
  $email = (isset($decode->data) ? $decode->data : "");
} catch (Exception $e) {
  $msg = $e->getMessage();
  if ($msg === "Expired token") {
    die(header("Location: /logout"));
  }
}

$USER = new User();
$VISIT = new Visit();
$VALIDATION = new Validation();
$user = $USER->user_view_email([$email]);

if ($action === "create") {
  try {
    $user_id = (isset($_POST['user_id']) ? $_POST['user_id'] : "");
    $type = (isset($_POST['type']) ? $_POST['type'] : "");
    $customer_id = (isset($_POST['customer_id']) ? $_POST['customer_id'] : "");
    $customer_user = (isset($_POST['customer_user']) ? $_POST['customer_user'] : "");
    $customer_name = (isset($_POST['customer_name']) ? $_POST['customer_name'] : "");
    $customer_contact = (isset($_POST['customer_contact']) ? $_POST['customer_contact'] : "");
    $customer_project = (isset($_POST['customer_project']) ? $_POST['customer_project'] : "");
    $reason = (isset($_POST['reason']) ? $_POST['reason'] : "");
    $opportunity = (isset($_POST['opportunity']) ? $_POST['opportunity'] : "");
    $remark = (isset($_POST['remark']) ? $_POST['remark'] : "");
    $latitude = (isset($_POST['latitude']) ? $_POST['latitude'] : "");
    $longitude = (isset($_POST['longitude']) ? $_POST['longitude'] : "");

    $customer_count = $VISIT->customer_count([$customer_user, $customer_name]);
    if (intval($customer_count) === 0 && !empty($customer_user)) {
      $VISIT->customer_create([$customer_user, $customer_name, $customer_contact, $customer_project]);
      $customer_id = $VISIT->last_insert_id();
    }

    $request_count = $VISIT->request_count([$customer_id, $remark]);
    if (intval($request_count) === 0) {
      $VISIT->request_create([$user_id, $type, $customer_id, $reason, $opportunity, $remark, $latitude, $longitude]);
    }

    $type_name = (intval($type) === 1 ? "ลูกค้าใหม่" : "ลูกค้าเก่า");
    $reason_name = (intval($reason) === 1 ? "นำเสนอ" : (intval($reason) === 2 ? "คุยงาน" : "เสนอราคา"));
    $date = date("d/m/Y, H:i น.");
    $text = "
แจ้งเตือน Visit Plan
ผู้ทำรายการ: {$user['fullname']}
ประเภทลูกค้า: {$type_name}
บริษัท: {$customer_name}
วัถตุประสงค์: {$reason_name}
รายละเอียดเพิ่มเติม:
{$remark}
{$date}
    ";
    $token = "acJ8lhYKWN5yzrHIr2B9WDvGtMinCjzKy6cekQwf9Za";
    $VALIDATION->line_notify($token, $text);

    $VALIDATION->alert("success", "ดำเนินการเรียบร้อย!", "/visit");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "update") {
  try {
    $id = (isset($_POST['id']) ? $_POST['id'] : "");
    $uuid = (isset($_POST['uuid']) ? $_POST['uuid'] : "");
    $reason = (isset($_POST['reason']) ? $_POST['reason'] : "");
    $remark = (isset($_POST['remark']) ? $_POST['remark'] : "");

    $VISIT->request_update([$reason, $remark, $uuid]);

    $VALIDATION->alert("success", "ดำเนินการเรียบร้อย!", "/visit/view/{$uuid}");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "delete") {
  try {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];

    if (!empty($id)) {
      $VISIT->request_delete([$id]);
      echo json_encode(200);
    } else {
      echo json_encode(500);
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "auth-create") {
  try {
    $user_id = (isset($_POST['user_id']) ? $_POST['user_id'] : "");

    $auth_count = $VISIT->auth_count([$user_id]);
    if (intval($auth_count) === 0) {
      $VISIT->auth_create([$user_id]);
    }

    $VALIDATION->alert("success", "ดำเนินการเรียบร้อย!", "/visit/auth");
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "auth-delete") {
  try {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'];

    if (!empty($id)) {
      $VISIT->auth_delete([$id]);
      echo json_encode(200);
    } else {
      echo json_encode(500);
    }
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "user-select") {
  try {
    $keyword = (isset($_POST['q']) ? $VALIDATION->input($_POST['q']) : "");
    $result = $VISIT->user_select($keyword);

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "customer-select") {
  try {
    $keyword = (isset($_POST['q']) ? $VALIDATION->input($_POST['q']) : "");
    $result = $VISIT->customer_select($keyword);

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "customer-detail") {
  try {
    $data = json_decode(file_get_contents("php://input"), true);
    $customer = $data['customer'];
    $result = $VISIT->customer_detail([$customer]);

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "request-data") {
  try {
    $date = (isset($_POST["date"]) ? $_POST["date"] : "");
    $type = (isset($_POST["type"]) ? $_POST["type"] : "");
    $reason = (isset($_POST["reason"]) ? $_POST["reason"] : "");
    $result = $VISIT->request_data($user['id'], $date, $type, $reason);

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "manage-data") {
  try {
    $date = (isset($_POST["date"]) ? $_POST["date"] : "");
    $user = (isset($_POST["user"]) ? $_POST["user"] : "");
    $type = (isset($_POST["type"]) ? $_POST["type"] : "");
    $reason = (isset($_POST["reason"]) ? $_POST["reason"] : "");
    $result = $VISIT->manage_data($date, $user, $type, $reason);

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "auth-data") {
  try {
    $result = $VISIT->auth_data();

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "type-select") {
  try {
    $data = ["ลูกค้าใหม่", "ลูกค้าเก่า"];

    $result = [];
    foreach ($data as $key => $value) {
      $key++;
      $result[] = [
        "id" => $key,
        "text" => $value,
      ];
    }

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}

if ($action === "reason-select") {
  try {
    $data = ["นำเสนอ", "คุยงาน", "เสนอราคา"];

    $result = [];
    foreach ($data as $key => $value) {
      $key++;
      $result[] = [
        "id" => $key,
        "text" => $value,
      ];
    }

    echo json_encode($result);
  } catch (PDOException $e) {
    die($e->getMessage());
  }
}
