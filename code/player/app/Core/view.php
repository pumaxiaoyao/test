<?php
namespace App\Core;

use \Xiaoler\Blade\FileViewFinder;
use \Xiaoler\Blade\Factory;
use \Xiaoler\Blade\Compilers\BladeCompiler;
use \Xiaoler\Blade\Engines\CompilerEngine;
use \Xiaoler\Blade\Filesystem;
use \Xiaoler\Blade\Engines\EngineResolver;

class View
{

    public static function getView(){
        $views = [
            PUBLIC_PATH.'/app/Views'
        ];
        $cache = PUBLIC_PATH.'/cache';
        $file = new Filesystem;
        $compiler = new BladeCompiler($file, $cache);
        
        // you can add a custom directive if you want
        $compiler->directive('nowtime', function() {
         return '<?php echo date("Y-m-d H:i:s", time());';
        });
        
        $resolver = new EngineResolver;
        $resolver->register('blade', function () use ($compiler) {
            return new CompilerEngine($compiler);
        });
        
        // get an instance of factory
        $factory = new Factory($resolver, new FileViewFinder($file, $views));
        
        return $factory;
    }
}