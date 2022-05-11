<?php // board.php

// 컨펌 처리
if (isset($_POST['confirm'])) {
  // TODO: 권한 체크 한번 더
  // if (!checkPerm()>=1) {
  //   header("Location: $MAIN?action=board");
  // }
  // TODO: 메시지
  if (isset($_POST['thread'])) {
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
        break;

      case 'update':
        $threadid = $_POST['threadid'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $pinned = (isset($_POST['pinned']))?1:0;
        $secret = (isset($_POST['secret']))?1:0;
        $userid = ($USER)?$USER['userid']:$_SERVER['REMOTE_ADDR'];
        $nickname = ($USER)?$USER['nickname']:'Guest';
        $wdate = time();

        $sql = "UPDATE thread SET
                title = '$title',
                content = '$content',
                pinned = '$pinned',
                secret = '$secret'
                WHERE threadid = '$threadid'";
        mysqli_query($DB, $sql);
        header("Location: $MAIN?action=board");
        break;

      case 'delete':
        $threadid = $_POST['threadid'];
        $sql = "DELETE FROM thread WHERE threadid = '$threadid'";
        mysqli_query($DB, $sql);
        header("Location: $MAIN?action=board");
        break;

    }
  } elseif (isset($_POST['reply'])) {
    switch ($DO) {
      case 'write':
        $threadid = $_POST['threadid'];
        $content = $_POST['content'];
        $secret = (isset($_POST['secret']))?1:0;
        $userid = ($USER)?$USER['userid']:$_SERVER['REMOTE_ADDR'];
        $nickname = ($USER)?$USER['nickname']:'Guest';
        $wdate = time();

        $sql = "INSERT INTO reply
                (wdate, userid, nickname, content, threadid, secret)
                VALUES
                ('$wdate', '$userid', '$nickname', '$content', '$threadid', '$secret')";
        mysqli_query($DB, $sql);

        $sql = "UPDATE thread SET
                replycnt = replycnt + 1
                WHERE threadid = '$threadid'";
        mysqli_query($DB, $sql);
        
        header("Location: $MAIN?action=board");
        break;

    }
  }
}