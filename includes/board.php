<?php

// TODO: 공지사항 pinned 구현
// 카테고리 선택 버튼 추가

function makeThread() {
  global $DB;

  $items = 10;
  $page = 1;
  $postCount = 0;
  $pageCount = 0;

  $sql = "SELECT COUNT(*) FROM thread";
  $res = mysqli_query($DB, $sql);
  $postCount = mysqli_fetch_row($res)[0];
  $pageCount = ceil($postCount / $items);

  $sql = "SELECT * FROM thread 
          ORDER BY threadid DESC 
          LIMIT 0, $items ";
  $res = mysqli_query($DB, $sql);

  $list = '';
  while ($data = mysqli_fetch_assoc($res)) {
    $threadid = $data['threadid'];
    $content = $data['content'];
    $nickname = $data['nickname'];
    $wdate = date("Y-m-d H:i:s", $data['wdate']);
    $pinned = $data['pinned'];
    $secret = $data['secret'];
    $list .= "
      <div class='thread'>
        <div class='header'>
          <span class='number'>#$threadid</span>
        </div>
        <div class='content'>
          <div class='message'>$content</div>
          <div class='info'>
            <span class='username'>$nickname</span>
            <span class='wdate'>$wdate</span>
            <span class='buttons'>[삭제]</span>
          </div>
        </div>
      </div>
    ";
  }
  return $list;
}

$board_template = <<<HTML
  <section class="list board">
    <div class="header">
      <div class="title">게시판</div>
    </div>
    <div class="content">
      {list}
    </div>
  </section>

HTML;

$board_data = array(
  '{list}' => makeThread(),
);

$board_content = strtr($board_template, $board_data);