<?php
// echo shell_exec('grep php /proc/net/unix');
// https://stackoverflow.com/questions/48935304/access-php-status-information-from-inside-php
exec( 'SCRIPT_NAME=/status SCRIPT_FILENAME=/status REQUEST_METHOD=GET cgi-fcgi -bind -connect /run/php-fpm/blog.sock', $php_fpm_status );
// Above statement will assign an array to $php_fpm_status filled with every line of output from the command, make it as whole string
$php_fpm_status = implode(PHP_EOL, $php_fpm_status);
// You can try printing php-fpm status
echo $php_fpm_status;

// https://github.com/wizaplace/php-fpm-status-cli