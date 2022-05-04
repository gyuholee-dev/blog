<?php // main.php
// 초기화
require_once 'includes/init.php';
require_once 'includes/elements.php';

$content = '';
switch ($ACT) {
  case 'main':
    $content .= makeList('바로가기', 'tile', 'portpolio', 'link', 0, 4);
    $content .= makeList('최신 게시물', 'tile', 'all', 'all', 0, 12);
    break;
  case 'profile':
    $content .= makePost($ACT, 1);
    break;
  case 'portpolio':
    $content .= makePost($ACT, $ID);
    $content .= makeList('바로가기', 'tile', 'portpolio', 'link', 0, 4);
    break;
  case 'study':
    $content .= makePost($ACT, $ID);
    break;
  case 'diary':
    $content .= makePost($ACT, $ID);
    break;

  case 'board':
    include INC.'board.php';
    $content .= $board_content;
    // $content .= renderElement(TPL.'board.html');
    break;

  case 'user':
    include INC.'user.php';
    if ($USER) {
        switch ($DO) {
        case 'logout':
          logout();
          header('Location: main.php');
          break;
        case 'delete':
          break;
        default:
          $content .= makeUserPage();
          break;
      }
    } else {
      switch ($DO) {
        case 'login':
          $content .= renderElement(TPL.'login.html');
          break;
        case 'signup':
          $content .= renderElement(TPL.'signup.html');
          break;

        default:
          pushLog('로그인 후 이용해주세요.');
          $content .= renderElement(TPL.'login.html');
          break;
      }
    }
    break;

  default : // main
    $content .= makeList('바로가기', 'tile', 'portpolio', 'link', 0, 4);
    $content .= makeList('최신 게시물', 'tile', 'all', 'all', 0, 12);
}

//------------------------ 랜더링 ------------------------

$html_data = array(
  'head' => makeHead(),
  // 'message' => printLog(),
  'header' => makeHeader(),
  'nav' => makeNav(),
  'content' => $content,
  'aside' => '',
  'footer' => makeFooter(),
  'postScript' => getLibraries('postscripts'),
);
echo renderElement(TPL.'template.html', $html_data);
