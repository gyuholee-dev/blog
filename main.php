<?php // main.php
// 초기화
require_once 'includes/init.php';

// 컨텐츠
$head = '';
$header = '';
$nav = '';
$content = '';
$aside = '';
$footer = '';

// 헤드
$head = <<<HTML
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="favicon.ico">
  <title>$info[siteTitle]</title>
HTML;
foreach ($libraries as $key => $library) {
  foreach ($library as $lib) {
    if ($key == 'styles') {
      $head .= "<link rel='stylesheet' href='$lib'>";
    } elseif ($key == 'scripts') {
      $head .= "<script type='text/javascript' src='$lib'></script>";
    }
  }
}

// 헤더
$siteUrl = ($_SERVER['HTTP_HOST']=='localhost')?'index.php':$info['siteUrl'];
$headerLink = "<a href='$siteUrl'><img src='images/$theme[logo]'></a>";
$loginLink = getLoginLink();
$header_values = array(
  '{headerLink}' => "<a href='$siteUrl'><img src='images/$theme[logo]'></a>",
  '{loginLink}' => $loginLink
);
$header = file_get_contents('templates/_header.html');
$header = strtr($header, $header_values);

// 네비게이션메뉴
foreach ($pages as $key => $conf) {
  $active = ($page==$key)?'active':'';
  $nav .= "<li class='$active'><a href='$MAIN?page=$key'>$conf[name]</a></li>";
}
$nav = '<ul class="menu main">'.$nav.'</ul>';

// 사이드메뉴
$aside = '';

// 푸터
$footer = <<<HTML
  <p>$info[copyright]</p>
HTML;


// 콘텐츠
include "pages/$action.php";


// 콘솔로그
$consoleLog = consoleLog();

// 포스트스크립트
$postScript = '';

//------------------------ 랜더링 ------------------------

$content_values = array( 
  '{head}' => $head,
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
