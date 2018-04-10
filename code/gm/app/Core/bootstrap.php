<?php
namespace App\Core;
use Illuminate\Database\Capsule\Manager as Capsule;

require PUBLIC_PATH.'/vendor/autoload.php';
// 注册 whoops 错误提示
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

use \Xiaoler\Blade\Autoloader as blade;
$blade = new blade;
$blade->register();

// Eloquent ORM

$capsule = new Capsule;
$capsule->addConnection(require PUBLIC_PATH.'/app/Config/database.php');
$capsule->bootEloquent();
