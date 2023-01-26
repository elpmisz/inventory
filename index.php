<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once(__DIR__ . "/vendor/autoload.php");
$Router = new AltoRouter();

$Router->map("GET", "/", function () {
  require(__DIR__ . "/views/home/login.php");
});
$Router->map("GET", "/info", function () {
  require(__DIR__ . "/views/home/info.php");
});
$Router->map("GET", "/home", function () {
  require(__DIR__ . "/views/home/index.php");
});
$Router->map("GET", "/itemdashboard", function () {
  require(__DIR__ . "/views/home/item.php");
});
$Router->map("GET", "/error", function () {
  require(__DIR__ . "/views/home/error.php");
});
$Router->map("GET", "/login", function () {
  require(__DIR__ . "/views/home/login.php");
});
$Router->map("GET", "/register", function () {
  require(__DIR__ . "/views/home/register.php");
});
$Router->map("GET", "/forget", function () {
  require(__DIR__ . "/views/home/forget.php");
});
$Router->map("GET", "/logout", function () {
  require(__DIR__ . "/views/home/logout.php");
});
$Router->map("POST", "/auth/[**:params]", function ($params) {
  require(__DIR__ . "/views/home/action.php");
});

$Router->map("GET", "/system", function () {
  require(__DIR__ . "/views/systems/index.php");
});
$Router->map("POST", "/system/[**:params]", function ($params) {
  require(__DIR__ . "/views/systems/action.php");
});

$Router->map("GET", "/users", function () {
  require(__DIR__ . "/views/users/index.php");
});
$Router->map("POST", "/users/data", function () {
  require(__DIR__ . "/views/users/data.php");
});
$Router->map("GET", "/users/profile", function () {
  require(__DIR__ . "/views/users/profile.php");
});
$Router->map("GET", "/users/create", function () {
  require(__DIR__ . "/views/users/create.php");
});
$Router->map("GET", "/users/view/[**:params]", function ($params) {
  require(__DIR__ . "/views/users/view.php");
});
$Router->map("GET", "/users/excel/[**:params]", function ($params) {
  require(__DIR__ . "/views/users/excel.php");
});
$Router->map("POST", "/users/[**:params]", function ($params) {
  require(__DIR__ . "/views/users/action.php");
});

$Router->map("GET", "/products", function () {
  require(__DIR__ . "/views/product/index.php");
});
$Router->map("POST", "/products/data", function () {
  require(__DIR__ . "/views/product/data.php");
});
$Router->map("GET", "/products/request", function () {
  require(__DIR__ . "/views/product/request.php");
});
$Router->map("GET", "/products/form", function () {
  require(__DIR__ . "/views/product/form.php");
});
$Router->map("GET", "/products/view/[**:params]", function ($params) {
  require(__DIR__ . "/views/product/view.php");
});
$Router->map("GET", "/products/excel/[**:params]", function ($params) {
  require(__DIR__ . "/views/product/excel.php");
});
$Router->map("POST", "/products/[**:params]", function ($params) {
  require(__DIR__ . "/views/product/action.php");
});

$Router->map("GET", "/borrow", function () {
  require(__DIR__ . "/views/borrow/index.php");
});
$Router->map("GET", "/borrow/manage", function () {
  require(__DIR__ . "/views/borrow/manage.php");
});
$Router->map("GET", "/borrow/item", function () {
  require(__DIR__ . "/views/borrow/item.php");
});
$Router->map("GET", "/borrow/request", function () {
  require(__DIR__ . "/views/borrow/request.php");
});
$Router->map("POST", "/borrow/datarequest", function () {
  require(__DIR__ . "/views/borrow/data_request.php");
});
$Router->map("POST", "/borrow/dataapprove", function () {
  require(__DIR__ . "/views/borrow/data_approve.php");
});
$Router->map("POST", "/borrow/databorrow", function () {
  require(__DIR__ . "/views/borrow/data_borrow.php");
});
$Router->map("GET", "/borrow/view/[**:params]", function ($params) {
  require(__DIR__ . "/views/borrow/view.php");
});
$Router->map("GET", "/borrow/approve/[**:params]", function ($params) {
  require(__DIR__ . "/views/borrow/approve.php");
});
$Router->map("GET", "/borrow/complete/[**:params]", function ($params) {
  require(__DIR__ . "/views/borrow/complete.php");
});
$Router->map("POST", "/borrow/[**:params]", function ($params) {
  require(__DIR__ . "/views/borrow/action.php");
});
$Router->map("GET", "/borrow/[**:params]", function ($params) {
  require(__DIR__ . "/views/borrow/action.php");
});


$match = $Router->match();

if (is_array($match) && is_callable($match['target'])) {
  call_user_func_array($match['target'], $match['params']);
} else {
  header("HTTP/1.1 404 Not Found");
  require __DIR__ . "/views/home/error.php";
}
