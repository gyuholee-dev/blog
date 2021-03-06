<?php // board.php
// TODO: 작성 및 수정한 글로 돌아가기
// TODO: 포스트 쓰레드 리플 처리
// print_r($_POST);
// return false;
// 컨펌 처리
if (isset($_POST['submit'])) {
  if (isset($_POST['thread'])) {
    switch ($DO) {
      case 'write':
        $title = $_POST['title'];
        $content = strip_tags($_POST['content']);
        $pinned = isset($_POST['pinned'])?1:0;
        $secret = isset($_POST['secret'])?1:0;
        $userid = ($USER)?$USER['userid']:$_SERVER['REMOTE_ADDR'];
        $nickname = ($USER)?$USER['nickname']:'Guest';
        $postid = isset($_POST['postid'])?$_POST['postid']:0;
        $wdate = time();
        $threadnumb = 0;

        $sql = "SELECT IFNULL(MAX(threadnumb),0) AS threadnumb FROM thread 
                WHERE pinned = '$pinned' AND postid = '$postid'";
        $res = mysqli_query($DB, $sql);
        $threadnumb = mysqli_fetch_row($res)[0] + 1;

        $sql = "INSERT INTO thread
                (threadnumb, wdate, userid, nickname, title, content, postid, pinned, secret)
                VALUES
                ('$threadnumb', '$wdate', '$userid', '$nickname', '$title', '$content', '$postid', '$pinned', '$secret')";
        mysqli_query($DB, $sql);

        if ($postid != 0) {
          $sql = "UPDATE post SET 
                  threadcnt = threadcnt+1 
                  WHERE postid = '$postid'";
          mysqli_query($DB, $sql);
        }

        $msg = ($pinned == 1)?
          "고정 #$threadnumb 쓰레드를 작성하였습니다.":
          "#$threadnumb 쓰레드를 작성하였습니다.";
        pushLog($msg, 'success');
        if ($ACT == 'board') {
          header("Location: $MAIN?action=board");
        } else {
          header("Location: $MAIN?action=$ACT&do=post&postid=$ID");
        }
        break;

      case 'update':
        $threadid = $_POST['threadid'];
        $threadnumb = $_POST['threadnumb'];
        $title = $_POST['title'];
        $content = strip_tags($_POST['content']);
        $pinned = isset($_POST['pinned'])?1:0;
        $secret = isset($_POST['secret'])?1:0;
        $pullup = isset($_POST['pullup'])?1:0;
        $pinchanged = isset($_POST['pinchanged'])?$_POST['pinchanged']:0;
        $secchanged = isset($_POST['secchanged'])?$_POST['secchanged']:0;
        $userid = ($USER)?$USER['userid']:$_SERVER['REMOTE_ADDR'];
        $nickname = ($USER)?$USER['nickname']:'Guest';
        $postid = isset($_POST['postid'])?$_POST['postid']:0;
        $wdate = 'wdate';
        $pullupcnt = 'pullupcnt';

        if ($pinchanged == 1) {
          $sql = "SELECT IFNULL(MAX(threadnumb),0) AS threadnumb FROM thread 
          WHERE pinned = '$pinned' AND postid = '$postid'";
          $res = mysqli_query($DB, $sql);
          $threadnumb = mysqli_fetch_row($res)[0] + 1;
        }
        if ($pullup == 1) {
          $wdate = "'".time()."'";
          $pullupcnt = "pullupcnt+1";
        }
        
        $sql = "UPDATE thread SET 
                threadnumb = '$threadnumb',
                wdate = $wdate,
                title = '$title',
                content = '$content',
                postid = '$postid',
                pinned = '$pinned',
                secret = '$secret',
                pullupcnt = $pullupcnt
                WHERE threadid = '$threadid'";
        mysqli_query($DB, $sql);

        $msg = ($pinned == 1)?
          "고정 #$threadnumb 쓰레드를 수정하였습니다.":
          "#$threadnumb 쓰레드를 수정하였습니다.";
        pushLog($msg, 'success');
        if ($ACT == 'board') {
          header("Location: $MAIN?action=board");
        } else {
          header("Location: $MAIN?action=$ACT&do=post&postid=$ID");
        }
        break;

      case 'delete':
        $threadid = $_POST['threadid'];
        $threadnumb = $_POST['threadnumb'];
        $pinned = isset($_POST['pinned'])?$_POST['pinned']:0;
        $postid = isset($_POST['postid'])?$_POST['postid']:0;

        $sql = "DELETE FROM thread WHERE threadid = '$threadid'";
        mysqli_query($DB, $sql);
        $sql = "DELETE FROM reply WHERE threadid = '$threadid'";
        mysqli_query($DB, $sql);
        if ($postid != 0) {
          $sql = "UPDATE post SET 
                  threadcnt = threadcnt-1 
                  WHERE postid = '$postid'";
          mysqli_query($DB, $sql);
        }

        $msg = ($pinned == 1)?
          '고정 쓰레드를 삭제하였습니다.':
          "#$threadnumb 쓰레드와 답글을 삭제하였습니다.";
        pushLog($msg, 'success');
        if ($ACT == 'board') {
          header("Location: $MAIN?action=board");
        } else {
          header("Location: $MAIN?action=$ACT&do=post&postid=$ID");
        }
        break;

    }
  } elseif (isset($_POST['reply'])) {
    switch ($DO) {
      case 'write':
        $threadid = $_POST['threadid'];
        $threadnumb = $_POST['threadnumb'];
        $content = strip_tags($_POST['content']);
        $secret = (isset($_POST['secret']))?1:0;
        $userid = ($USER)?$USER['userid']:$_SERVER['REMOTE_ADDR'];
        $nickname = ($USER)?$USER['nickname']:'Guest';
        // $postid = isset($_POST['postid'])?$_POST['postid']:0;
        $wdate = time();

        $sql = "INSERT INTO reply
                (wdate, userid, nickname, content, threadid, secret)
                VALUES
                ('$wdate', '$userid', '$nickname', '$content', '$threadid', '$secret')";
        mysqli_query($DB, $sql);
        
        $sql = "UPDATE thread SET
                replycnt = replycnt+1
                WHERE threadid = '$threadid'";
        mysqli_query($DB, $sql);

        pushLog("#$threadnumb 쓰레드의 답글을 작성하였습니다.", 'success');
        if ($ACT == 'board') {
          header("Location: $MAIN?action=board");
        } else {
          header("Location: $MAIN?action=$ACT&do=post&postid=$ID");
        }
        break;

      case 'delete':
        $replyid = $_POST['replyid'];
        $threadid = $_POST['threadid'];
        $threadnumb = $_POST['threadnumb'];
        // $postid = isset($_POST['postid'])?$_POST['postid']:0;

        $sql = "DELETE FROM reply WHERE replyid = '$replyid'";
        mysqli_query($DB, $sql);

        $sql = "UPDATE thread SET
                replycnt = replycnt-1
                WHERE threadid = '$threadid'";
        mysqli_query($DB, $sql);

        pushLog("#$threadnumb 쓰레드의 답글을 삭제하였습니다.", 'success');
        if ($ACT == 'board') {
          header("Location: $MAIN?action=board");
        } else {
          header("Location: $MAIN?action=$ACT&do=post&postid=$ID");
        }
        break;

    }
  }
}