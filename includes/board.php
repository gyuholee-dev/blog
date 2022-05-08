<?php

function getButton($type, $label='', $attr=array()) : string
{
  $tag = 'button';
  if ($type == 'submit' || $type == 'reset') {
    $tag = 'input';
  }
  $class = 'btn';
  if (isset($attr['class'])) {
    $class .= ' '.$attr['class'];
  }

  $button = "<$tag class='$class' ";
  if ($tag != 'button' && $tag != $type) {
    $button .= "type='$type' ";
  }
  foreach ($attr as $key => $value) {
    $button .= "$key='$value' ";
  }
  if ($tag=='input' && !isset($attr['value'])) {
    $button .= "value='$label' ";
  }
  $button .= ">";
  if ($tag=='button') {
    $button .= "$label</$tag>";
  }
  return $button;
}

// TODO: 공지사항 pinned 구현
function getThread($data) {
  foreach ($data as $key => $value) {
    $$key = $value;
  }
  $isThread= !isset($replyid);
  if ($isThread) {
    $type = 'thread';
    $postId = $threadid;
    $postTitle = "#$postId $title";
    $buttonReply = getButton('button', '답글', ['class'=>'min']);
    $buttonEdit =
      getButton('button', '수정', ['class'=>'min']).
      getButton('button', '삭제', ['class'=>'min']);
  } else {
    $type = 'reply';
    $postId = $replyid;
    $postTitle = '';
    $buttonReply = '';
    $buttonEdit = getButton('button', '삭제', ['class'=>'min']);
  }
  $wdate = date("Y-m-d H:i:s", $data['wdate']);

  $thread_data = array(
    'type' => $type,
    'postTitle' => $postTitle,
    'content' => $content,
    'buttonReply' => $buttonReply,
    'wdate' => $wdate,
    'nickname' => $nickname,
    'buttonEdit' => $buttonEdit
  );
  return renderElement(TPL.'list_thread.html', $thread_data);
}

function makeThreadList() {
  global $DB;

  $items = 10;
  $page = 1;
  $postCount = 0;
  $pageCount = 0;

  $sql = "SELECT COUNT(*) FROM thread";
  $res = mysqli_query($DB, $sql);
  $postCount = mysqli_fetch_row($res)[0];
  $pageCount = ceil($postCount / $items);

  $sql = "SELECT * FROM thread 
          WHERE postid = 0
          ORDER BY threadid DESC 
          LIMIT 0, $items ";
  $res = mysqli_query($DB, $sql);

  $html = "";
  while ($data = mysqli_fetch_assoc($res)) {
    $html .= '<div class="wrap chain">';
    $html .= getThread($data);
    // 답글
    if ($data['replycnt'] > 0) {
      $sql = "SELECT * FROM reply 
              WHERE threadid = '$data[threadid]' ";
      $reply_res = mysqli_query($DB, $sql);
      while ($reply_data = mysqli_fetch_assoc($reply_res)) {
        $html .= getThread($reply_data);
      } 
    }
    $html .= '</div>';
  }
  return $html;
}

$board_data = array(
  'list' => makeThreadList(),
);
$board_content = renderElement(TPL.'board.html', $board_data);