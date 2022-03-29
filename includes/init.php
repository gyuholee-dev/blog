<?php // init.php
require_once 'includes/functions.php';

// 글로벌 변수
global $BACKLOG; // 백엔드 로그 배열
global $DB; // DB 연결
global $MAIN; // 메인 페이지


// ## 로그 배열 선언
$BACKLOG = array();

// DB 환경변수
$dbConfig = json_decode(
  file_get_contents('./configs/'.
    'db'.(file_exists('./configs/db.json')?'':'.default').'.json'
  ),
true);

$host = $dbConfig['host'];
$user = $dbConfig['user'];
$pass = $dbConfig['pass'];
$DB = mysqli_connect($host, $user, $pass);
mysqli_select_db($DB, 'gyuholee');

// 블로그 환경변수
// TODO: 환경변수를 global 로 명시적 선언
global $MAIN;
$blogConfig = json_decode(
  file_get_contents('./configs/blog.json'), 
true);
pushLog($blogConfig);

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
 * view&do=main
 *         post&postid=1
 *         list&category=all
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
$postid = 0;

$fileName = basename($_SERVER['PHP_SELF']);
$page = isset($_REQUEST['page'])?$_REQUEST['page']:$page;
$action = isset($_REQUEST['action'])?$_REQUEST['action']:$action;
$do = isset($_REQUEST['do'])?$_REQUEST['do']:$do;
$pnum = isset($_REQUEST['pnum'])?$_REQUEST['pnum']:$pnum;
$postid = isset($_REQUEST['postid'])?$_REQUEST['postid']:$postid;

// 세션 시작
session_start();
