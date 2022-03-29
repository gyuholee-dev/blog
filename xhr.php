<?php // xhr.php
require_once('includes/init.php');

// 함수 리퀘스트
if ($_GET['call']) {
    $call = $_GET['call'];
} else {
    echo 'XHR_INVALID_ACCESS';
    exit();
}
$callFN = 'xhr_'.$call;


// 리퀘스트 들어온 함수를 실행한다
if (function_exists($callFN)) {
    $callFN();
} else {
    echo json_encode('XHR_CALL_UNKNOWN_FUNCTION: '.$callFN);
    exit();
}

function xhr_test() {
    echo json_encode($_GET);
}

function xhr_checkId() {
    $userid = $_GET['userid'];
    $result = checkId($userid);
    echo $result;
} 