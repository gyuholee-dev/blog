<?php // board.php

// 컨펌 처리
if (isset($_POST['confirm'])) {
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
        pushLog('새 글을 작성하였습니다.', 'success');
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
        pushLog('글을 수정하였습니다.', 'success');
        header("Location: $MAIN?action=board");
        break;

      case 'delete':
        // TODO: 답글도 전부 삭제
        $threadid = $_POST['threadid'];
        $sql = "DELETE FROM thread WHERE threadid = '$threadid'";
        mysqli_query($DB, $sql);
        pushLog('글을 삭제하였습니다.', 'success');
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

        pushLog('답글을 작성하였습니다.', 'success');
        header("Location: $MAIN?action=board");
        break;

      case 'delete':
        $replyid = $_POST['replyid'];
        $sql = "DELETE FROM reply WHERE replyid = '$replyid'";
        mysqli_query($DB, $sql);
        pushLog('답글을 삭제하였습니다.', 'success');
        header("Location: $MAIN?action=board");
        break;

    }
  }
}