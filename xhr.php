<?php // xhr.php
require_once('includes/init.php');

// XHR 함수명 선언
$callFN = 'xhr_test';

// ## 함수 리퀘스트
if (isset($_GET['call'])) {
  $call = $_GET['call'];
} else {
  echo 'XHR_INVALID_ACCESS';
  exit();
}
$callFN = 'xhr_'.$call;

// ## 리퀘스트 들어온 함수를 실행한다
if (function_exists($callFN)) {
  $callFN();
} else {
  echo json_encode('XHR_CALL_UNKNOWN_FUNCTION: '.$callFN);
  exit();
}

// ## XHR 테스트함수
// echo 로 리턴
// 리턴값을 받아 console.log 로 출력해봄
function xhr_test() {
  echo json_encode($_GET);
}

// ## XHR 유저아이디 검사
function xhr_checkId() {
  echo checkId($_GET['userid']);
} 