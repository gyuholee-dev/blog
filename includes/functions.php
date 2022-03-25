<?php //functions.php

// ------------------------ 기본 함수 ------------------------

// 콘솔 출력
function console_log($log) {
  if (is_array($log)) {
    $log = json_encode($log);
    $script = "
        <script id='backendLog'>
           var log = JSON.parse('$log');
           console.log(log);
           backendLog.remove();
        </script>
    ";
  } else {
    $log = preg_replace('/\s+/', ' ', $log);
    $log = addslashes($log);
    $script = "
        <script id='backendLog'>
           var log = '$log';
           console.log(log);
           backendLog.remove();
        </script>
    ";
  }

  echo $script;
}

// 값이 date 인지 검사
function isDate($str) {
	$d = date('Y-m-d', strtotime($str));
	return $d == $str;
}

// 숫자를 자릿수 맞춰서 문자열로 변환
function numStr($numb, $numSize) {
  $add = '0';
  for ($i=0; $i < $numSize; $i++) { 
    $add = $add.'0';
  }
  $numb = $add.(string)$numb;
  $numb = substr($numb, 0-$numSize);
  return $numb;
}

// ------------------------ 블로그 엘리먼트 함수 ------------------------

// 포스트 출력
function makePost($page, $idx) {
  global $db;
  global $pages;

  $sql = "SELECT * FROM post
  WHERE category = '$page' ";

  if ($idx != 0) {
  $sql .= "AND idx = $idx ";
  } else {
  $items = $pages[$page]['items'];
  $sql .= "ORDER BY idx DESC LIMIT 0, $items ";
  }
  
  $res = mysqli_query($db, $sql);

  $html = '';
  while ($data = mysqli_fetch_assoc($res)) {

    $headerClass = 'header';
    $headerBG = '';
    $file = '';
    $wdate = date("Y-m-d H:i:s", $data['wdate']);

    if ($data['posttype'] == 'text' && $data['file'] != '') {
      $headerClass = 'header img';
      $headerBG = "<div class='bg' style='background-image:url(\"files/$data[file]\")'></div>";
    } elseif ($data['posttype'] == 'media' && $data['file'] != '') {
      $file = "<img src='files/$data[file]'>";
    }

    $html .= <<<HTML
      <section class="post $data[posttype]">
        <div class="$headerClass">
          $headerBG
          <div class="title">$data[title]</div>
          <div class="subcategoty">$data[subcategory]</div>
        </div>
        <div class="content">
          $file
          $data[content]
        </div>
        <div class="footer">
          <div class="info">
            <div class="wdate">$wdate</div>
            <div class="username">$data[writer]</div>
          </div>
        </div>
      </section>
    HTML;
  }

  return $html;

}  