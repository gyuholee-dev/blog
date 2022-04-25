<?php // init.php
// 초기화 ------------------------------------------------
require_once 'includes/functions.php';
require_once 'includes/elements.php';
ini_set('display_errors', 'On');
ini_set('session.use_strict_mode', 0);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();

// 패스 상수 선언
// define('ROOT', '/'.basename(getcwd()).'/');
define('INC', './includes/');
define('CONF', './configs/');
define('DATA', './data/');
define('FILE', './files/');
define('PAGE', './');
define('IMG', './images/');
define('STL', './styles/');
define('SCT', './scripts/');
define('TPL', './templates/');
define('MAIN', 'main.php');

//글로벌 변수
global $MSG;
global $INFO;
global $CONF;
global $USER;
global $DB;
global $DBCONF;
global $PAGE;
global $ACT;

// 설정파일 로드
$CONF = openJson(CONF.'config.json');
// $MAIN = $CONF['mainFile'];

// 메시지
if (isset($_SESSION['MSG'])) {
    $MSG = $_SESSION['MSG'];
    // js 출력시 프린트후 삭제
    // unset($_SESSION['MSG']);
} else {
    $MSG = [
        'info' => '',
        'success' => '',
        'error' => ''
    ];
}

// DB 초기화 ------------------------------------------------

// DB 설정파일 로드
$dbConfigFile = 'db.blog.json';
if (!fileExists(CONF.$dbConfigFile)) {
    $dbConfigFile = 'db.default.json';
}
$DBCONF = openJson(CONF.$dbConfigFile);

// DB설정 체크, 접속, 테이블 검사
$dbLog = '';
$DB = connectDB($DBCONF);
if (!$DB) {
    $dbLog = 'DB 접속에 실패하였습니다.';
} else {
    $fileList = glob(DATA.'travel_*.sql');
    foreach ($fileList as $file) {
        $table = str_replace('.sql', '', basename($file));
        if (!checkTable($table)) {
            $dbLog = '테이블이 존재하지 않습니다.';
            $DB = disconnectDB($DB);
            break;
        }
    }
}
if ($dbLog) {
    pushLog($dbLog.' 셋업을 실행해 주세요. [<a href="setup.php">바로가기</a>]', 'error');
}
unset($dbConfigFile, $dbLog);


// 사이트 초기화 ------------------------------------------------

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
$PAGE = isset($_REQUEST['page'])?$_REQUEST['page']:'main';
$ACT = isset($_REQUEST['action'])?$_REQUEST['action']:'view';

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

