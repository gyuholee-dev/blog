<?php //functions.php

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