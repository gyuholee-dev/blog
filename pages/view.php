<?php // view.php

// $page 에 따라 각각 다른 컨텐츠를 출력
// TODO: $pages 컨피그에서 변수를 가져옴
// TODO: $do 파라메터에 따라 메인, 포스트, 리스트를 출력
// TODO: 변수와 출력을 분리
switch ($page) {
  case 'main':
    // 링크
    $content .= makeList('바로가기', 'tile', 'portpolio', 'link', 0, 4);
    // 최신게시물
    $content .= makeList('최신 게시물', 'tile', 'all', 'all', 0, 12);
    break;
  case 'profile':
    // 포스트
    $content .= makePost($page, 1);
    break;
  case 'portpolio':
    // 포스트
    $content .= makePost($page, $postid);
    // 링크
    $content .= makeList('바로가기', 'tile', 'portpolio', 'link', 0, 4);
    break;
  case 'study':
    if ($postid != 0) {
      $content .= makePost($page, $postid);
    } else {
      $content .= makeList('리스트', 'table', $page, 'all', 0, 10);
    }
    break;
  case 'diary':
    $content .= makePost($page, $postid);
    break;
  case 'board':
    $content .= '';
    break;
}