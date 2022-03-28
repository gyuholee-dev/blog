<?php // init.php
require_once 'includes/functions.php';

// DB 환경변수
global $DB;
$dbConfig = json_decode(
  file_get_contents('./configs/db.config'), 
true);
// console_log($dbConfig);
$host = $dbConfig['host'];
$user = $dbConfig['user'];
$pass = $dbConfig['pass'];
$DB = mysqli_connect($host, $user, $pass);
mysqli_select_db($DB, 'gyuholee');

// 블로그 환경변수
// TODO: 환경변수를 gloval 로 명시적 선언
global $MAIN;
$blogConfig = json_decode(
  file_get_contents('./configs/blog.config'), 
true);
console_log($blogConfig);

$MAIN = $blogConfig['mainFile'];
$info = $blogConfig['info'];
$theme = $blogConfig['theme'];
$libraries = $blogConfig['libraries'];
$pages = $blogConfig['pages'];

/** 기본 파라메터 변수
 * action=view
 *        edit
 *        user
 *        manage
 * view&do=post
 *         list
 * edit&do=create
 *         update
 *         delete
 * user&do=login
 *         logout
 *         signup
 *         mypage
 */

// 파라메터 변수
$fileName = '';
$page = 'main';
$action = 'view';
$do = 'post';
$pnum = 1;
$idx = 0;

$fileName = basename($_SERVER['PHP_SELF']);
$page = isset($_REQUEST['page'])?$_REQUEST['page']:$page;
$action = isset($_REQUEST['action'])?$_REQUEST['action']:$action;
$do = isset($_REQUEST['do'])?$_REQUEST['do']:$do;
$pnum = isset($_REQUEST['pnum'])?$_REQUEST['pnum']:$pnum;
$idx = isset($_REQUEST['idx'])?$_REQUEST['idx']:$idx;
