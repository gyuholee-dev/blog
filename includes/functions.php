<?php // functions.php

// 클래스 오토로드
function _autoLoad($className) : void
{
  $classPath = 'classes/';
  if (preg_match('/\/?(.+)\/(.+)/i', str_replace('\\', '/', $className), $matches)) {
    $namespace = $matches[1];
    $className = $matches[2];
    if ($namespace != DEFAULT_NAMESPACE) {
      $classPath = $namespace.'/';
    }
  }
  require INC.$classPath.$className.'.php';
}
spl_autoload_register('_autoLoad');

// 기초 함수 ------------------------------------------------

// json5_decode
// https://github.com/colinodell/json5
function json5_decode($source, $associative = false, $depth = 512, $options = 0)
{   
  return \Json5\Json5Decoder::decode($source, $associative, $depth, $options);
}

// 디바이스 체크 (2013)
// https://mobiforge.com/design-development/tablet-and-mobile-device-detection-php
function detectDevice() : string
{
  $tablet_browser = 0;
  $mobile_browser = 0;
  
  if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $tablet_browser++;
  }
  
  if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $mobile_browser++;
  }
  
  if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
    $mobile_browser++;
  }
  
  $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
  $mobile_agents = array(
    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
    'newt','noki','palm','pana','pant','phil','play','port','prox',
    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
    'wapr','webc','winw','winw','xda ','xda-'
  );
  
  if (in_array($mobile_ua,$mobile_agents)) {
    $mobile_browser++;
  }
  
  if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
    $mobile_browser++;
    //Check for tablets on opera mini alternative headers
    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
      $tablet_browser++;
    }
  }
  
  if ($tablet_browser > 0) {
    // do something for tablet devices
    return 'tablet';
  } else if ($mobile_browser > 0) {
    // do something for mobile devices
    return 'mobile';
  } else {
    // do something for everything else
    return 'desktop';
  }
}

// 테마모드
function detectTheme() : string
{
  global $CONF;

  $mode = 'auto';
  if (isset($_COOKIE['THEME'])) {
    $mode = $_COOKIE['THEME'];
  } else if (isset($CONF['theme']['defaultTheme'])) {
    $mode = $CONF['theme']['defaultTheme'];
  }

  return $mode;
}

// 경고 출력
function alert(string $msg, string $url=null) : void
{
  $script = 'alert("'.$msg.'");';
  $script .= $url?'location.href="'.$url.'";':'';
  $script = "<script>$script</script>";
  echo $script;
}

// 로그 입력
// info, success, error
function pushLog(string $log, string $class='info') : bool
{
  global $MSG;
  $MSG[$class] .= ($MSG[$class] != '')?' | ':'';
  $MSG[$class] .= $log;
  $_SESSION['MSG'] = $MSG;
  return true;
}

// 로그 출력
function printLog() : string
{
  global $MSG;
  $html = '';
  foreach ($MSG as $type => $log) {
    $html .= $log?"<div class='log $type'>$log</div>":'';
  }
  return "<div id='message'>$html</div>";
}

// 파일 존재 검사
function fileExists(string $file) : bool
{
  return file_exists($file);
}

// json 파일 오픈
function openJson($file)
{
  if (!fileExists($file)) {
    return false;
  }
  $json = file_get_contents($file);
  // $json = json_decode($json, true);
  $json = json5_decode($json, true);
  return $json;
}

// json 파일 세이브
function saveJson($file, $data)
{
  $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
  return file_put_contents($file, $json);
}

// 코드 생성
// 현재 시간을 소스로 최대 32자 임의 문자열 생성
function makeCode($max=32, $upper=false)
{
  $code = md5(time());
  if ($max <= 32) {
    $code = substr($code, 0, $max);
  }
  if ($upper) {
    $code = strtoupper($code);
  }
  return $code;
}

// 카멜케이스 변환
function toSnake($string) {
  return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $string)), '_');
}
function toCamel($string) {
  return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $string))));
}

// 숫자를 자릿수 맞춰서 문자열로 변환
function numStr($numb, $numSize)
{
  $add = '0';
  for ($i=0; $i < $numSize; $i++) {
    $add = $add.'0';
  }
  $numb = $add.(string)$numb;
  $numb = substr($numb, 0-$numSize);
  return $numb;
}

// 유저기능 함수 ------------------------------------------------

// 권한 검사
function checkPerm(int $require) : bool
{
  global $USER, $CONF;
  if (!$USER) {
    return ($CONF['permission']['guest'] >= $require);
  }
  return ($CONF['permission'][$USER['groups']] >= $require);
}

// 글 작성자 체크
// TODO: 글 조회해서 작성자와 비교하는 기능 추가
function isOwner($userid) : bool
{
  global $USER;
  if (!$USER) return false;
  return $USER['userid'] == $userid;
}

// 유저 아이디 존재 검사
// TODO: 테이블명 및 필드명 변수처리
function checkId($userid)
{
  global $DB;
  $sql = "SELECT * FROM user WHERE userid = '$userid' ";
  $res = mysqli_query($DB, $sql);
  return mysqli_num_rows($res);
}

// 로그인 처리
// 로그인은 별도 함수로 만들지 않음
// TODO: 권한 정수값 추가
function setUserData(array $userData) : bool
{
  global $USER;
  $USER = array(
    'userid' => $userData['userid'],
    'nickname' => $userData['nickname'],
    'groups' => $userData['groups'],
    'key' => makeCode(),
    'pref' => [
      'theme' => isset($_COOKIE['THEME'])?$_COOKIE['THEME']:'',
    ]
  );
  $_SESSION['USER'] = $USER;
  setcookie('USER', json_encode($USER), time()+3600);
  return true;
}

// 로그아웃
function logout() : void
{
  global $MSG;
  unsetUserData();
  pushLog('로그아웃되었습니다.', 'info');
  header('Location: main.php');
}

// 로그아웃 처리
function unsetUserData() : bool
{
  global $USER;
  $USER = null;
  unset($_SESSION['USER']);
  setcookie('USER', '', time()-3600);
  return true;
}

// 유저 데이터 삭제
function deleteUserData($userid) : bool
{
  global $DB;
  $sql = "DELETE FROM user WHERE userid = '$userid' ";
  $res = mysqli_query($DB, $sql);
  return $res;
}

// 회원탈퇴
function signout() : bool
{
  global $MSG;
  global $USER;
  if (!$USER) return false;
  if ($USER['groups'] == 'admin') {
    pushLog('관리자는 탈퇴할 수 없습니다.', 'error');
    header('Location: main.php');
    return false;
  }
  $userid = $USER['userid'];
  deleteUserData($userid);
  unsetUserData();
  pushLog('회원탈퇴하였습니다.', 'error');
  return true;
}

// DB 함수 ------------------------------------------------

// AES 암호화
function AES_ENCRYPT($plaintext, $key)
{
  // TODO: PHP 암호화 라이브러리를 통해 암호화 구현
  global $DB;
  $sql = "SELECT AES_ENCRYPT('$plaintext', '$key') AS ciphertext ";
  $result = mysqli_query($DB, $sql);
  $row = mysqli_fetch_assoc($result);
  return $row['ciphertext'];
}

// AES 암호해독
function AES_DECRYPT($ciphertext_raw, $key)
{
  // TODO: PHP 암호화 라이브러리를 통해 해독 구현
  global $DB;
  $sql = "SELECT AES_DECRYPT('$ciphertext_raw', '$key') AS plaintext ";
  $result = mysqli_query($DB, $sql);
  $row = mysqli_fetch_assoc($result);
  return $row['plaintext'];
}

// DB 접속
function connectDB($dbConfig, $log=false)
{
  global $DB;
  global $MSG;
  foreach ($dbConfig as $key => $value) {
    $$key = $value;
  }
  try {
    $DB = mysqli_connect(
      $hostname,
      $username,
      $password,
      $database,
      $port,
      $socket
    );
    if ($log) {
      pushLog('DB 접속 성공', 'success');
    }
    return $DB;
  } catch (Exception $e) {
    if ($log) {
      pushLog('DB 접속 실패: '.$e->getMessage(), 'error');
    }
    return false;
  }
}

// DB 접속해제
function disconnectDB($log=false)
{
  global $DB;
  global $MSG;
  try {
    mysqli_close($DB);
    if ($log) {
      pushLog('DB 접속해제 성공', 'success');
    }
    return null;
  } catch (Exception $e) {
    if ($log) {
      pushLog('DB 접속해제 실패: '.$e->getMessage(), 'error');
    }
    return false;
  }
}

// 테이블 검사
function checkTable($table, $log=false)
{
  global $DB;
  global $MSG;
  
  $sql = "SHOW TABLES LIKE '$table'";
  $rows = mysqli_num_rows(mysqli_query($DB, $sql));
  
  if ($rows == 0) {
    if ($log) {
      pushLog("테이블 없음: $table", 'error');
    }
    return false;
  }
  if ($log) {
    pushLog("테이블 있음: $table", 'success');
  }
  return true;
}
