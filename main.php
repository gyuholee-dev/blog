<?php // main.php
// 초기화
require_once 'includes/init.php';
require_once 'includes/start.php';


//------------------------ 랜더링 ------------------------

$content_values = array(
    '{head}' => $head,
    '{header}' => $header,
    '{nav}' => $nav,
    '{content}' => $content,
    '{aside}' => $aside,
    '{footer}' => $footer,
    '{consoleLog}' => $consoleLog,
    '{postScript}' => $postScript
);

$html = file_get_contents('templates/template.html');
$html = strtr($html, $content_values);
echo $html;
