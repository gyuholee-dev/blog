<?php // study.php

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
    <section class="post text">
      <div class="header">
        <div class="title">$data[title]</div>
        <div class="subcategoty">$data[subcategory]</div>
      </div>
      <div class="content">
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