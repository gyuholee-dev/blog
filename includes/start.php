<?php
require_once 'includes/elements.php';

$main = MAIN;
$info = $CONF['info'];
$theme = $CONF['theme'];
$libraries = $CONF['libraries'];
$pages = $CONF['pages'];

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
  $active = ($PAGE==$key)?'active':'';
  $nav .= "<li class='$active'><a href='$main?page=$key'>$conf[name]</a></li>";
}
$nav = '<ul class="menu main">'.$nav.'</ul>';

// 사이드메뉴
$aside = '';

// 푸터
$footer = <<<HTML
  <p>$info[copyright]</p>
HTML;

// 포스트스크립트
$postScript = '';