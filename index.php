<?php
$blogConfig = json_decode(
  file_get_contents('./configs/blog.config'), 
true);
header('Location:'.$blogConfig['mainFile']);