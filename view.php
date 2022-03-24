<?php // view.php
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
  <title>블로그</title>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Nanum+Myeongjo&family=Quicksand&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <!-- <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script> -->
  <script type="text/javascript" src="scripts/script.js"></script>
HTML;

// 헤더
$header = <<<HTML
  <div class="logo">
    <a href="view.php">
      <img src="images/logo.png">
    </a>
  </div>
  <div class="menu top">
    <div class="links">
      <a href="github"><i class="xi-github"></i></a>
      <a href="twitter"><i class="xi-twitter"></i></a>
      <a href="facebook"><i class="xi-facebook"></i></a>
      <a href="kakaotalk"><i class="xi-kakaotalk"></i></a>
    </div>
    <div class="search">
      <a href="search"><i class="xi-search"></i></a>
      <!-- <input type="text"><button>검색</button> -->
    </div>
  </div>
HTML;

// 네비게이션메뉴
$active = [
  'profile' => '',
  'portpolio' => '',
  'study' => '',
  'diary' => '',
  'board' => ''
];
$active[$page] = 'active';
$nav = <<<HTML
  <ul class="menu main">
    <li class="$active[profile]"><a href="view.php?page=profile">LeeGyuho</a></li>
    <li class="$active[portpolio]"><a href="view.php?page=portpolio">Portpolio</a></li>
    <li class="$active[study]"><a href="view.php?page=study">Study</a></li>
    <li class="$active[diary]"><a href="view.php?page=diary">Diary</a></li>
    <li class="$active[board]"><a href="view.php?page=board">Board</a></li>
  </ul>
HTML;

// 사이드메뉴
$aside = '';

// 푸터
$footer = <<<HTML
  <p>Copyright © LeeGyuho all right reserved.</p>
HTML;


// 콘텐츠 메인페이지
// TODO: $action 값에 따라 각각 다른 페이지를 인클루드 
include "pages/$page.php";

//------------------------ 랜더링 ------------------------
$content_values = array( 
  '{head}' => $head,
  '{header}' => $header,
  '{nav}' => $nav,
  '{content}' => $content,
  '{aside}' => $aside,
  '{footer}' => $footer,
);

$html = file_get_contents('templates/template.html');
$html = strtr($html, $content_values);
echo $html;
