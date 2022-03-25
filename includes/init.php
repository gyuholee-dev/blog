<?php // init.php
require_once 'includes/functions.php';

// DB 환경변수
$dbConfig = json_decode(
  file_get_contents('./configs/db.config'), 
true);
// console_log($dbConfig);
$host = $dbConfig['host'];
$user = $dbConfig['user'];
$pass = $dbConfig['pass'];
$db = mysqli_connect($host, $user, $pass);
mysqli_select_db($db, 'gyuholee');

// 글로벌 변수
$fileName = '';
$page = 'main';

$fileName = basename($_SERVER['PHP_SELF']);
$page = isset($_REQUEST['page'])?$_REQUEST['page']:$page;

// 블로그 환경변수
$blogConfig = json_decode(
  file_get_contents('./configs/blog.config'), 
true);
console_log($blogConfig);
