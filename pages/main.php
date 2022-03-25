<?php // main.php

$listLinks = '';
$listLastest = '';

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


// 최신 게시물 리스트
$sql = "SELECT * FROM post  
        ORDER BY idx DESC 
        LIMIT 0, 12 ";
$res = mysqli_query($db, $sql);

while ($data = mysqli_fetch_assoc($res)) {
  $itemClass = ($data['posttype']=='media')?'item wide':'item';
  $boxClass = "box ".$data['posttype'];
  $link = "view.php?page=$data[category]&idx=$data[idx]";
  if ($data['posttype']=='media' && $data['file'] != '') {
    $background = "<div class='bg' style='background-image:url(\"files/$data[file]\")'></div>";
  } else { $background = ''; }

  $listLastest .= <<<HTML
    <li class="$itemClass">
      <div class="$boxClass" onclick="location.href='$link'">
        $background
        <div class="post">
          <div class="title">$data[title]</div>
          <div class="summary">$data[content]</div>
        </div>
      </div>
    </li>
  HTML;
  $i++;
}


$content = <<<HTML
  <section class="list tile">
    <div class="title xi-bookmark-o">바로가기</div>
    <ul class="tile">
      $listLinks
    </ul>
  </section>

  <section class="list tile">
    <div class="title xi-view-module">최신 게시물</div>
    <ul class="tile">
      $listLastest
    </ul>
    <!-- <div id="loading">
      <i class="xi-spin xi-spinner-3"></i>
    </div> -->
  </section>
HTML;