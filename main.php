<?php // main.php
// 초기화
require_once 'includes/init.php';
require_once 'includes/elements.php';

$content = '';
switch ($ACT) {
  case 'main':
    $content .= makePostPage($ACT, 1);
    $content .= makeList('최신 게시물', 'tile', 'all', 'all', 0, 12);
    $content .= makeList('바로가기', 'tile', 'project', 'link', 0, 4);
    break;
  case 'project':
    $content .= makeList('바로가기', 'tile', 'project', 'link', 0, 4);
    $content .= makePostPage($ACT, $ID);
    break;
  case 'study':
    $content .= makePostPage($ACT, $ID);
    break;
  case 'diary':
    $content .= makePostPage($ACT, $ID);
    break;

  case 'board':
    include INC.'board.php';
    $content .= makeBoardPage();
    break;

  case 'user':
    if ($USER) {
      switch ($DO) {
        case 'mypage':
          $content .= makeUserPage();
          break;
        case 'logout':
          logout();
          header("Location: $MAIN");
          break;
        case 'signout':
          signout();
          header("Location: $MAIN");
          break;
          
        default:
          header("Location: $MAIN?action=$ACT&do=mypage");
          break;
      }
    } else {
      include INC.'user.php';
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
    header("Location: $MAIN");
    break;
}

//------------------------ 랜더링 ------------------------
// 프리로드
preloadLibrary();

// 랜더링
$html_data = array(
  'head' => makeHead(),
  'header' => makeHeader(),
  'content' => $content,
  'leftmenu' => makeSidemenu('left'),
  'rightmenu' => makeSidemenu('right'),
  'footer' => makeFooter(),
  'postScript' => getLibraries('postscripts'),
);
echo renderElement(TPL.'template.html', $html_data);
