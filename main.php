<?php // main.php
// 초기화
require_once 'includes/init.php';
require_once 'includes/elements.php';

// $page 에 따라 각각 다른 컨텐츠를 출력
$content = '';
if ($ACT == 'view') {
  switch ($PAGE) {
    case 'main':
      // 링크
      $content .= makeList('바로가기', 'tile', 'portpolio', 'link', 0, 4);
      // 최신게시물
      $content .= makeList('최신 게시물', 'tile', 'all', 'all', 0, 12);
      break;
    case 'profile':
      // 포스트
      $content .= makePost($PAGE, 1);
      break;
    case 'portpolio':
      // 포스트
      $content .= makePost($PAGE, $ID);
      // 링크
      $content .= makeList('바로가기', 'tile', 'portpolio', 'link', 0, 4);
      break;
    case 'study':
      $content .= makePost($PAGE, $ID);
      break;
    case 'diary':
      $content .= makePost($PAGE, $ID);
      break;
    case 'board':
      $content .= '';
      break;
  }
} elseif ($ACT == 'user') {
  include PAGE.'user.php';
  // $DO 값에 따라 각각 다른 컨텐츠를 출력
  $formTitle = '';
  switch ($DO) {
    case 'login':
      // $formTitle = '로그인';
      $content .= $content_login;
      break;
    case 'logout':
      // $formTitle = '로그아웃';
      $content .= $content_logout;
      // unset($_SESSION['user']);
      session_destroy();
      header('Location: main.php');
      break;
    case 'signup':
      // $formTitle = '회원가입';
      $content .= $content_signup;
      break;
    case 'mypage':
      // $formTitle = '마이페이지';
      $content .= $content_mypage;
      break;
    case 'delete':
      // $formTitle = '회원탈퇴';
      $content .= $content_delete;
      break;
  }
}

//------------------------ 랜더링 ------------------------

$html_data = array(
  'head' => makeHead(),
  'message' => printLog($reset = true),
  'header' => makeHeader(),
  'nav' => makeNav(),
  'content' => $content,
  'aside' => '',
  'footer' => makeFooter(),
  'postScript' => ''
);
echo renderElement(TPL.'template.html', $html_data);
