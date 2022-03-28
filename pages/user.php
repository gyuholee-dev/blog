<?php // user.php

// $do 값에 따라 각각 다른 컨텐츠를 출력
switch ($do) {
  case 'login':
    $content .= '로그인';
    break;
  case 'logout':
    $content .= '로그아웃';
    break;
  case 'signup':
    $content .= '회원가입';
    break;
  case 'mypage':
    $content .= '마이페이지';
    break;
}