<?php // board.php

// 컨펌 처리
if (isset($_POST['confirm'])) {
  // 권한 체크 한번 더
  if (!checkPerm()>=1) {
    header("Location: $MAIN?action=board");
  }
  switch ($DO) {
    case 'write':
      $title = $_POST['title'];
      $content = $_POST['content'];
      $pinned = (isset($_POST['pinned']))?1:0;
      $secret = (isset($_POST['secret']))?1:0;
      $userid = ($USER)?$USER['userid']:$_SERVER['REMOTE_ADDR'];
      $nickname = ($USER)?$USER['nickname']:'Guest';
      $wdate = time();

      $sql = "INSERT INTO thread
              (wdate, userid, nickname, title, content, pinned, secret)
              VALUES
              ('$wdate', '$userid', '$nickname', '$title', '$content', '$pinned', '$secret')";
      mysqli_query($DB, $sql);
      header("Location: $MAIN?action=board");

  }
}