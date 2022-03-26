<?php // portpolio.php

// 포스트
$content .= makePost($page, $idx);

// TODO: 페이지 및 리스트 삽입

// 링크 리스트
$content .= makeList('바로가기', 'tile', 'portpolio', 'link', 0, 4);
