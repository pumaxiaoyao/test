<?php
namespace App\Core;

require PUBLIC_PATH.'/vendor/autoload.php';
// 注册 whoops 错误提示
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

use \Xiaoler\Blade\Autoloader as blade;
$blade = new blade;
$blade->register();

