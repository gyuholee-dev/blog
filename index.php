<?php
$blogConfig = json_decode(file_get_contents('./configs/blog.json'), true);
header('Location:'.$blogConfig['mainFile']);
