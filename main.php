<?php // main.php
// 초기화
require_once 'includes/init.php';
require_once 'includes/start.php';

// $page 에 따라 각각 다른 컨텐츠를 출력
// TODO: $pages 컨피그에서 변수를 가져옴
// TODO: $do 파라메터에 따라 메인, 포스트, 리스트를 출력
// TODO: 변수와 출력을 분리
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
            /* if ($ID != 0) {
                $content .= makePost($PAGE, $ID);
            } else {
                $content .= makeList('리스트', 'table', $PAGE, 'all', 0, 10);
            } */
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
        header('Location: '.$MAIN);
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

// 메시지 출력
$message = printLog(false);

//------------------------ 랜더링 ------------------------

$content_values = array(
    '{head}' => $head,
    '{message}' => $message,
    '{header}' => $header,
    '{nav}' => $nav,
    '{content}' => $content,
    '{aside}' => $aside,
    '{footer}' => $footer,
    '{consoleLog}' => $consoleLog,
    '{postScript}' => $postScript
);

$html = file_get_contents('templates/template.html');
$html = strtr($html, $content_values);
echo $html;
