<?php // portpolio.php

// 인덱스
$idx = isset($_REQUEST['idx'])?$_REQUEST['idx']:0;

// sql 
// TODO: 포스트 출력을 함수로 변경
$sql = "SELECT * FROM post
        WHERE category = '$page' ";
if ($idx != 0) {
  $sql .= "AND idx = $idx ";
} else {
  $items = $pages[$page]['items'];
  $sql .= "ORDER BY idx DESC LIMIT 0, $items ";
}
$res = mysqli_query($db, $sql);

while ($data = mysqli_fetch_assoc($res)) {
  $content .= <<<HTML
    <section class="post media">
      <div class="header">
        <div class="title">$data[title]</div>
        <div class="subcategoty">$data[subcategory]</div>
      </div>
      <div class="content">
        <img src="files/$data[file]">
        $data[content]
      </div>
      <div class="footer">
        <div class="info">
          <div class="wdate">2022-03-24 12:33</div>
          <div class="username">이규호</div>
        </div>
      </div>
    </section>
  HTML;
}

// TODO: 페이지 및 리스트 삽입

// TODO: 리스트를 함수로 변경
$listLinks = '';
// 링크 리스트
$sql = "SELECT * FROM post 
        WHERE 
        category = 'portpolio' AND 
        subcategory = 'link' 
        ORDER BY idx DESC 
        LIMIT 0, 4 ";
$res = mysqli_query($db, $sql);

$i = 0;
while ($data = mysqli_fetch_assoc($res)) {
  $itemClass = ($i==0)?'item wide':'item';
  $boxClass = ($i==0)?'box link active':'box link';

  $listLinks .= <<<HTML
    <li class="$itemClass">
      <div class="$boxClass" onclick="location.href='$data[link]'">
        <div class="bg" style="background-image:url('files/$data[file]')"></div>
        <div class="post">
          <div class="title">$data[title]</div>
          <div class="summary">$data[content]</div>
        </div>
      </div>
    </li>
  HTML;
  $i++;
}

$content .= <<<HTML
  <section class="list tile">
    <div class="title xi-bookmark-o">바로가기</div>
    <ul class="tile">
      $listLinks
    </ul>
  </section>
HTML;