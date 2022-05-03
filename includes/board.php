<?php

$items = 10;
$page = 1;
$postCount = 0;
$pageCount = 0;

$sql = "SELECT COUNT(*) FROM board";
$res = mysqli_query($DB, $sql);
$postCount = mysqli_fetch_row($res)[0];

$sql = "SELECT * FROM board";
$res = mysqli_query($DB, $sql);


$board_content = <<<HTML
  <section class="board $ACT">
    <div class="header">
      <div class="title">$postCount 개의 게시물이 있습니다.</div>
    </div>


    <div class="content"></div>
  </section>

HTML;