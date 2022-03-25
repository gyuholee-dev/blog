<?php // profile.php

// 프로필 인덱스
$idx = 1;

// sql
$sql = "SELECT * FROM post
        WHERE idx = 1 ";
$res = mysqli_query($db, $sql);
$data = mysqli_fetch_assoc($res);

// 출력
$content = <<<HTML
  <section class="post text">
    <div class="header img">
      <div class="bg" style="background-image:url('files/$data[file]')"></div>
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