<?php
/**
 * 简易PHP框架的构建器脚本，用于预读、加载指定PHP文件
 * php version 7.1
 * 
 * @category Utilities
 * @package  GM
 * @author   alien <email@email.com>
 * @license  Public http://alien.com
 * @link     http://alien.com
 */

/**
 * 通用脚本加载器
 * 
 * @return void
 */
function registerCommonHelper()
{
    $_modules = array("utilities", "ipsearch/ipsearch", "Def", "PublicArgus", 
        "verifycode/ValidateCode.class");
    registerModules(array("utilities", "thirdparties"), $_modules);
}

/**
 * 控制器脚本加载器
 * 
 * @param [array] $_modules 待加载的控制器脚本
 * 
 * @return void
 */
function registerCtrlHelper($_modules)
{
    registerModules(array("controllers",), $_modules);
}

/**
 * 视图脚本加载器
 *
 * @param [type] $_modules 待加载的视图脚本
 * 
 * @return void
 */
function registerViewHelper($_modules)
{
    registerModules(array("views",), $_modules);
}

/**
 * 数据模块加载器
 *
 * @param [type] $_modules 待加载的数据模块脚本
 * 
 * @return void
 */
function registerDataHelper($_modules)
{
    registerModules(array("models",), $_modules);
}

/**
 * 基础脚本加载模块，提供给各类别的加载器使用的基础方法
 *
 * @param [type] $_subpaths 文件子目录
 * @param [type] $_register 待加载的目标文件
 * 
 * @return void
 */
function registerModules($_subpaths, $_register)
{
    
    foreach ($_register as $_) {
        foreach ($_subpaths as $_subpath) {
            $_file = "./application/".$_subpath."/".$_.".php";
            if (file_exists($_file)) {
                require_once $_file;
            } else {
                //用于异常无法加载时的调试代码，可忽略
                // if (!in_array($_subpath, array("utilities", "thirdparties"))) {
                //     echo $_file;
                // }
            }
        }
    }
}

?>