<?php

// TODO: 공지사항 pinned 구현
// 카테고리 선택 버튼 추가


$items = 10;
$page = 1;
$postCount = 0;
$pageCount = 0;

$sql = "SELECT COUNT(*) FROM board";
$res = mysqli_query($DB, $sql);
$postCount = mysqli_fetch_row($res)[0];
$pageCount = ceil($postCount / $items);

$sql = "SELECT * FROM board 
        ORDER BY numb DESC 
        LIMIT 0, $items ";
$res = mysqli_query($DB, $sql);

$list = '';
while ($data = mysqli_fetch_assoc($res)) {
  $numb = $data['numb'];
  $title = $data['title'];
  $category = $data['category'];
  $nickname = $data['nickname'];
  $wdate = date("Y-m-d H:i:s", $data['wdate']);
  $secret = $data['secret'];
  $hit = $data['hit'];
  $list .= "
    <tr>
      <td>$numb</td>
      <td>$title</td>
      <td>$category</td>
      <td>$nickname</td>
      <td>$wdate</td>
      <td>$hit</td>
    </tr>
  ";
}

$board_content = <<<HTML
  <section class="board list table">
    <div class="header">
      <div class="title">게시판</div>
    </div>
    <div class="content">
      <table class="table">
        <tr>
          <th>번호</th>
          <th width="100%">제목</th>
          <th>구분</th>
          <th>글쓴이</th>
          <th>날짜</th>
          <th>조회수</th>
        </tr>
        $list
      </table>
    </div>
  </section>

HTML;