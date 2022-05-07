<?php
// 프리로드
// https://web.dev/i18n/ko/preload-critical-assets/
// Link: </css/style.css>; rel="preload"; as="style"
function preloadLibrary() : void
{
  global $CONF;
  $library = $CONF['libraries'];
  $html = '';
  foreach ($library as $key => $libs) {
    foreach ($libs as $lib) {
      if ($key == 'styles') {
        header("Link: <$lib>; rel=preload; as=style;");
      } elseif ($key == 'scripts') {
        header("Link: <$lib>; rel=preload; as=script;");
      } elseif ($key == 'postscripts') {
        header("Link: <$lib>; rel=preload; as=script;");
      }
    }
  }
}


// 템플릿을 로드하여 html 엘리먼트 생성
function renderElement(string $template, array $data=array()) : string 
{
  // default data
  $data['main'] = MAIN;

  if (!file_exists($template)) return '';
  $html = file_get_contents($template);
  foreach ($data as $key => $value) {
    $html = str_replace('{'.$key.'}', $value, $html);
  }
  return $html;
}

// ------------------------ 블로그 엘리먼트 함수 ------------------------

// 사이트 타이틀
// TODO: 서브타이틀 변경
function getSiteTitle() : string
{
  global $INFO;
  $siteTitle = $INFO['title'];
  $siteTitle .= ($INFO['subtitle'])??' : '.$INFO['subtitle'];
  return $siteTitle;
}

// 헤더링크
function getHeaderLink($type='logo') : string
{
  global $ACT, $CONF, $INFO;
  $active = ($ACT == 'main') ? 'active' : '';
  $theme = $CONF['theme'];
  $siteUrl = ($_SERVER['HTTP_HOST']=='localhost')?MAIN:$INFO['url'];
  if ($type == 'logo') {
    $logo = IMG.'icons/'.$theme['logo'];
    $link = "<a href='$siteUrl'><img src='$logo'></a>";
  } else if ($type == 'title') {
    $icon = '<i class="logo BI-icon-SL"></i>';
    $link = "<a href='$siteUrl'>$icon<span>$INFO[title]</span></a>";
  }

  $headerLink = <<<HTML
    <div class="title $active">
      $link<span class="sep"><i class="xi-angle-right"></i></span>
    </div>
  HTML;

  return $headerLink;
}

// 로그인링크
function getLoginLink($type='link') : string
{
  global $USER;
  $main = MAIN;
  if ($type == 'link') {
    if ($USER) {
      $loginLink = "
        <a href='$main?action=user&do=mypage'>Mypage</a>
        <a href='$main?action=user&do=logout'>Logout</a>
      ";
    } else {
      $loginLink = "
        <a href='$main?action=user&do=login'>Login</a>
        <a href='$main?action=user&do=signup'>Signup</a>
      ";
    }
  } else if ($type == 'icon') {
    if ($USER) {
      $loginLink = "
        <a href='$main?action=user&do=mypage'><i class='xi-user-o'></i></a>
      ";
    } else {
      $loginLink = "
        <a href='$main?action=user&do=login'><i class='xi-log-in'></i></a>
      ";
    }

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

function getLibraries($key = 'styles') : string
{
  global $CONF;
  $library = $CONF['libraries'][$key];
  $html = '';
  foreach ($library as $lib) {
    if ($key == 'styles') {
      $html .= "<link rel='stylesheet' href='$lib'>";
    } elseif ($key == 'scripts') {
      $html .= "<script type='text/javascript' src='$lib'></script>";
    } elseif ($key == 'postscripts') {
      $html .= "<script type='text/javascript' src='$lib'></script>";
    }
  }
  return $html;
  
}

// 네비게이션 출력
function getNavmenu($sep=null) : string
{
  global $CONF, $ACT;
  $main = MAIN;
  $pages = $CONF['pages'];

  $navmenu = '';
  foreach ($pages as $key => $conf) {
    if ($conf['visible'] != 'all' && !in_array('menu', $conf['visible'])) continue;
    $active = ($ACT==$key)?'active':'';
    $navmenu .= "<li class='$active'><a href='$main?action=$key'>$conf[name]</a></li>";
    if ($sep && $key != array_key_last($pages)) {
      $navmenu .= "<span class='sep'>$sep</span>";
    }
  }
  
  $navmenu = '<ul class="menu main">'.$navmenu.'</ul>';
  return $navmenu;

}

// --------------------------------------------------------------------------
  
// 헤드 출력
function makeHead() : string
{
  global $CONF, $INFO;
  $siteTitle = getSiteTitle();
  $description = $INFO['description'];
  $libraries = $CONF['libraries'];
  $favicon = IMG.'icons/'.$CONF['theme']['favicon'];

  $head = <<<HTML
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="$favicon">
    <title>$siteTitle</title>
    <meta name="description" content="$description">
  HTML;

  $head .= getLibraries('styles');
  $head .= getLibraries('scripts');

  return $head;
}

// 헤더 출력
function makeHeader() : string
{
  $header_data = array(
    'navmenu' => getNavmenu('<i class="xi-minus xi-rotate-90"></i>'),
    'headerLink' => getHeaderLink('title'),
    'loginLink' => getLoginLink('icon')
  );
  $header = renderElement(TPL.'header.html', $header_data);
  return $header;
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
function makePost($cat, $postid) 
{
  global $DB;
  global $CONF;
  $main = MAIN;
  $pages = $CONF['pages'];

  $sql = "SELECT * FROM post
  WHERE category = '$cat' ";
  if ($postid != 0) {
    $sql .= "AND postid = $postid ";
  } else {
    $items = $pages[$cat]['items'];
    $sql .= "ORDER BY postid DESC LIMIT 0, $items ";
  }
  $res = mysqli_query($DB, $sql);

  $html = '';
  while ($data = mysqli_fetch_assoc($res)) {
    foreach ($data as $key => $value) {
      $$key = $value;
    }
    $posttype = $pages[$cat]['postType'];
    $posttype .= $pinned?' pinned':'';

    $headerClass = 'header';
    $headerBG = '';
    $wdate = date("Y-m-d H:i:s", $wdate);
    if ($pinned) {
      $wdate = '[고정됨] '.$wdate;
    }

    if ($pinned == true && $file != '') {
      $headerClass = 'header img';
      $headerBG = "<div class='bg' style='background-image:url(\"files/$file\")'></div>";
      $file = '';
    }
    
    if (!$pinned && $posttype == 'media' && $file != '') {
      $file = "<img src='files/$file'>";
    }

    $category = ($category!='')?"<a href='$main?action=$category'>$category</a>":$category;
    $tags = getTagLink($tags);

    $textClass = ($posttype == 'media')?'center':'left';
    $content = "<p class='$textClass'>$content</p>";

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
      $linkUrl = "$main?action=$category&postid=$postid";
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
  // global $PAGE;
}

// 유저페이지 출력
// TODO: main.php 문자열을 MAIN 상수로 변경
function makeUserPage() : string
{
  global $DB, $USER, $DO;
  if (!isset($DO) || !isset($USER)) return false; 

  if ($DO == 'mypage') {
    $userid = $USER['userid'];
    $sql = "SELECT * FROM user WHERE userid = '$userid' ";
    $res = mysqli_query($DB, $sql);
    $data = mysqli_fetch_assoc($res);
  
    $mypage_data = array(
      'userid' => $data['userid'],
      'nickname' => $data['nickname'],
      'email' => $data['email'],
      'avatar' => $data['avatar'],
      'link' => $data['link']
    );
    $html = renderElement(TPL.'mypage.html', $mypage_data);
    
  } else {
    $html = renderElement(TPL.$DO.'.html');
  }
  
  return $html;
}