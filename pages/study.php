<?php // study.php

if ($idx != 0) {
  $content .= makePost($page, $idx);
} else {
  $content .= makeList('리스트', 'table', $page, 'all', 0, 10);
}

// TODO: 페이지 및 리스트 삽입