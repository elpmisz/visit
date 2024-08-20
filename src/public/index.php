<?php
require_once(__DIR__ . "/vendor/autoload.php");

$ROUTER = new AltoRouter();

##################### SERVICE #####################
################### VISIT ###################
$ROUTER->map("GET", "/visit", function () {
  require(__DIR__ . "/src/Views/visit/index.php");
});
$ROUTER->map("GET", "/visit/create", function () {
  require(__DIR__ . "/src/Views/visit/create.php");
});
$ROUTER->map("GET", "/visit/auth", function () {
  require(__DIR__ . "/src/Views/visit/auth.php");
});
$ROUTER->map("GET", "/visit/manage", function () {
  require(__DIR__ . "/src/Views/visit/manage.php");
});
$ROUTER->map("GET", "/visit/export", function () {
  require(__DIR__ . "/src/Views/visit/export.php");
});
$ROUTER->map("GET", "/visit/view/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/visit/view.php");
});
$ROUTER->map("GET", "/visit/edit/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/visit/edit.php");
});
$ROUTER->map("POST", "/visit/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/visit/action.php");
});


##################### SETTING #####################
##################### SYETEM #####################
$ROUTER->map("GET", "/system", function () {
  require(__DIR__ . "/src/Views/system/index.php");
});
$ROUTER->map("POST", "/system/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/system/action.php");
});

##################### USER #####################
$ROUTER->map("GET", "/user", function () {
  require(__DIR__ . "/src/Views/user/index.php");
});
$ROUTER->map("GET", "/user/create", function () {
  require(__DIR__ . "/src/Views/user/create.php");
});
$ROUTER->map("GET", "/user/profile", function () {
  require(__DIR__ . "/src/Views/user/profile.php");
});
$ROUTER->map("GET", "/user/change", function () {
  require(__DIR__ . "/src/Views/user/change.php");
});
$ROUTER->map("GET", "/user/edit/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/user/edit.php");
});
$ROUTER->map("POST", "/user/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/user/action.php");
});

##################### CUSTOMER #####################
$ROUTER->map("GET", "/customer", function () {
  require(__DIR__ . "/src/Views/customer/index.php");
});
$ROUTER->map("GET", "/customer/create", function () {
  require(__DIR__ . "/src/Views/customer/create.php");
});
$ROUTER->map("GET", "/customer/view/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/customer/view.php");
});
$ROUTER->map("POST", "/customer/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/customer/action.php");
});

##################### AUTH #####################
$ROUTER->map("GET", "/", function () {
  require(__DIR__ . "/src/Views/home/login.php");
});
$ROUTER->map("GET", "/home", function () {
  require(__DIR__ . "/src/Views/home/index.php");
});
$ROUTER->map("GET", "/info", function () {
  require(__DIR__ . "/src/Views/home/info.php");
});
$ROUTER->map("GET", "/error", function () {
  require(__DIR__ . "/src/Views/home/error.php");
});
$ROUTER->map("POST", "/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/home/action.php");
});
$ROUTER->map("GET", "/[**:params]", function ($params) {
  require(__DIR__ . "/src/Views/home/action.php");
});


$MATCH = $ROUTER->match();

if (is_array($MATCH) && is_callable($MATCH["target"])) {
  call_user_func_array($MATCH["target"], $MATCH["params"]);
} else {
  header("HTTP/1.1 404 Not Found");
  require_once(__DIR__ . "/src/Views/home/error.php");
}
