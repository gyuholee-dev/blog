<?php

// 템플릿을 로드하여 html 엘리먼트 생성
function renderElement(string $template, array $data) : string 
{
  $html = file_get_contents($template);
  foreach ($data as $key => $value) {
    $html = str_replace('{'.$key.'}', $value, $html);
  }
  return $html;
}

// ------------------------ 블로그 엘리먼트 함수 ------------------------

// 사이트 타이틀
function getSiteTitle() : string
{
  global $INFO;
  $siteTitle = $INFO['title'];
  $siteTitle .= ($INFO['subtitle'])??' : '.$INFO['subtitle'];
  return $siteTitle;
}

// 헤더링크
function getHeaderLink() : string
{
  global $CONF, $INFO;
  $theme = $CONF['theme'];
  $siteUrl = ($_SERVER['HTTP_HOST']=='localhost')?MAIN:$INFO['url'];
  $headerLink = "<a href='$siteUrl'><img src='images/$theme[logo]'></a>";
  return $headerLink;
}

// 로그인링크
function getLoginLink() : string
{
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

// 태그링크
function getTagLink(string $tags) : string
{
  $tags = explode(',', $tags);

  $html = '';
  foreach ($tags as $tag) {
    $html .= "<a href='#'>$tag</a>";
  }
  return $html;
}

// --------------------------------------------------------------------------
  
// 헤드 출력
function makeHead() : string
{
  global $CONF, $INFO;
  $siteTitle = getSiteTitle();
  $description = $INFO['description'];
  $libraries = $CONF['libraries'];

  $head = <<<HTML
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico">
    <title>$siteTitle</title>
    <meta name="description" content="$description">
  HTML;

  foreach ($libraries as $key => $library) {
    foreach ($library as $lib) {
      if ($key == 'styles') {
        $head .= "<link rel='stylesheet' href='$lib'>";
      } elseif ($key == 'scripts') {
        $head .= "<script type='text/javascript' src='$lib'></script>";
      }
    }
  }

  return $head;
}

// 헤더 출력
function makeHeader() : string
{
  $header_data = array(
    'headerLink' => getHeaderLink(),
    'loginLink' => getLoginLink()
  );
  $header = renderElement(TPL.'header.html', $header_data);
  return $header;
}

// 네비게이션 출력
function makeNav() : string
{
  global $CONF, $PAGE;
  $main = MAIN;
  $pages = $CONF['pages'];

  $nav = '';
  foreach ($pages as $key => $conf) {
    $active = ($PAGE==$key)?'active':'';
    $nav .= "<li class='$active'><a href='$main?page=$key'>$conf[name]</a></li>";
  }
  $nav = '<ul class="menu main">'.$nav.'</ul>';

  return $nav;
}

// 푸터 출력
function makeFooter() : string
{
  global $INFO;
  $footer = <<<HTML
    <p>$INFO[copyright]</p>
  HTML;
  return $footer;
}

// 포스트 출력
// TODO: pinned 기능 구현
function makePost($page, $postid) 
{
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
    $tags = getTagLink($tags);

    $post_data = array( 
      'posttype' => $posttype,
      'headerClass' => $headerClass,
      'headerBG' => $headerBG,
      'title' => $title,
      'category' => $category,
      'wdate' => $wdate,
      'writer' => $writer,
      'tags' => $tags,
      'file' => $file,
      'content' => $content,
    );
    
    $html .= renderElement(TPL.'post.html', $post_data);
  }

  return $html;

}

// 리스트 출력
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


  $listTemplate = file_get_contents(TPL.'list_'.$listType.'.html');
  
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

// 페이지 넘버 출력
function makePageNumber() {
  global $pnum;
  global $pages;
}