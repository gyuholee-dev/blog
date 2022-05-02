<?php

// ------------------------ 블로그 엘리먼트 함수 ------------------------

// ## 멤버정보
function getLoginLink() {
    $main = MAIN;
    $loginLink = "
      <a href='$main?action=user&do=login'>Login</a>
      <a href='$main?action=user&do=signup'>Signup</a>
    ";
    if (isset($_SESSION['USER'])) {
      $loginLink = "
        <a href='$main?action=user&do=mypage'>Mypage</a>
        <a href='$main?action=user&do=logout'>Logout</a>
      ";
    }
    return $loginLink;
  }
  
  
  // ## 태그링크 출력
  // TODO: tagList 구현
  function makeTagLink($tags) {
    $tags = explode(',', $tags);
  
    $html = '';
    foreach ($tags as $tag) {
      $html .= "<a href='#'>$tag</a>";
    }
    return $html;
  }
  
  // ## 포스트 출력
  // TODO: pinned 기능 구현
  function makePost($page, $postid) {
    global $DB;
    global $CONF;
    $pages = $CONF['pages'];
  
    $sql = "SELECT * FROM post
    WHERE category = '$page' ";
    if ($postid != 0) {
      $sql .= "AND postid = $postid ";
    } else {
      $items = $pages[$page]['items'];
      $sql .= "ORDER BY postid DESC LIMIT 0, $items ";
    }
    $res = mysqli_query($DB, $sql);
  
    $html = '';
    while ($data = mysqli_fetch_assoc($res)) {
      foreach ($data as $key => $value) {
        $$key = $value;
      }
      $posttype = $pages[$page]['postType'];
  
      $headerClass = 'header';
      $headerBG = '';
      $wdate = date("Y-m-d H:i:s", $wdate);
  
      if ($pinned == true && $file != '') {
        $headerClass = 'header pinned img';
        $headerBG = "<div class='bg' style='background-image:url(\"files/$file\")'></div>";
        $file = '';
      } 
      
      if ($posttype == 'media' && $file != '') {
        $file = "<img src='files/$file'>";
      }
  
      $category = ($category!='')?"<a href='main.php?page=$category'>$category</a>":$category;
      $tags = makeTagLink($tags);
  
      $post_values = array( 
        '{posttype}' => $posttype,
        '{headerClass}' => $headerClass,
        '{headerBG}' => $headerBG,
        '{title}' => $title,
        '{category}' => $category,
        '{wdate}' => $wdate,
        '{writer}' => $writer,
        '{tags}' => $tags,
        '{file}' => $file,
        '{content}' => $content,
      );
      
      $template = file_get_contents('templates/_post.html');
      $html .= strtr($template, $post_values);
    }
  
    return $html;
  
  }
  
  // ## 리스트 출력
  // TODO: 테이블 리스트 출력 기능 추가
  function makeList($listTitle='리스트', $listType='tile', $category='all', $posttype='all', $start=false, $end=false) {
    global $DB;
    
    $main = MAIN;
    $postCount = 0;
    $whereSql = '';
    $orderSql = '';
    $limitSql = '';
  
    $whereSql .= "WHERE 1 = 1 ";
    if ($category != 'all') {
      $whereSql .= "AND category = '$category' ";
    }
    if ($posttype != 'all') {
      $whereSql .= "AND posttype = '$posttype' ";
    }
  
    $sql = "SELECT COUNT(*) FROM post $whereSql";
    $res = mysqli_query($DB, $sql);
    $postCount = mysqli_fetch_row($res)[0];
  
    $orderSql .= "ORDER BY postid DESC ";
    
    if ($start !== false) {
      $end = ($end !== false)?$end:$postCount;
      $limitSql .= "LIMIT $start, $end ";
    }
  
    $sql = "SELECT * FROM post ";
    $sql .= $whereSql.$orderSql.$limitSql;
    // console_log($sql);
    $res = mysqli_query($DB, $sql);
  
  
    $listTemplate = file_get_contents('templates/_list'.$listType.'.html');
    
    $reg = '/\{listItem start\}(.+)\{listItem end\}/is';
    preg_match($reg, $listTemplate, $matches);
    $itemTemplate = $matches[1];
  
    $i = 0;
    $listItem = '';
    while ($data = mysqli_fetch_assoc($res)) {
      foreach ($data as $key => $value) {
        $$key = $value;
      }
  
      $itemClass = 'item';
      $boxClass = 'box '.$posttype;
      $headerBG = '';
      $linkUrl = '';
      $listBG = '';
      $wdate = date("Y-m-d H:i:s", $wdate);
  
      if ($posttype == 'link' && $i == 0 || $posttype=='media') {
        $itemClass .= ' wide';
      }
      if ($posttype == 'link' && $i == 0 || $posttype=='media') {
        $boxClass .= ' active';
      }
      if ($posttype=='link') {
        $linkUrl = $link;
      } else {
        $linkUrl = "$main?page=$category&postid=$postid";
      }
      if ($posttype=='link' || $posttype=='media') {
        if ($data['file'] != '') {
          $listBG = "<div class='bg' style='background-image:url(\"files/$file\")'></div>";
        }
      }
  
      $item_values = array( 
        '{itemClass}' => $itemClass,
        '{boxClass}' => $boxClass,
        '{headerBG}' => $headerBG,
        '{linkUrl}' => $linkUrl,
        '{listBG}' => $listBG,
        '{title}' => $title,
        '{category}' => $category,
        '{content}' => $content,
        '{wdate}' => $wdate,
        '{writer}' => $writer,
      );
  
      $listItem .= strtr($itemTemplate, $item_values); 
      $i++;
    }
  
    $listTemplate = preg_replace($reg, '{listItem}', $listTemplate);
    $list_values = array(
      '{listTitle}' => $listTitle,
      '{listItem}' => $listItem,
    );
  
    return strtr($listTemplate, $list_values);
  
  }
  
  
  
  // ## 페이지 넘버 출력
  function makePageNumber() {
    global $pnum;
    global $pages;
  }