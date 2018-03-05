<?php
/**
 * 初始化构建器
 */

function registerCommonHelper($_modules = array("utilities", "gt3sdk/web/StartCaptchaServlet","PublicArgus", "utilitiesAgents")){
    /**
     * common工具的加载脚本，默认导入所需各种基础工具库
     * 该工具库在路由层会优先导入一次，不用手动加载
     */
    registerModules(array("utilities", "thirdparties"), $_modules);
}

function registerCtrlHelper($_modules){
    /**
     * Controllers的loader
     */
    registerModules(array("controllers",), $_modules);
}

function registerViewHelper($_modules){
    /**
     * ViewHelper的loader
     */
    registerModules(array("views",), $_modules);
}

function registerDataHelper($_modules){
    /**
     * datamodule的loader
     */
    registerModules(array("models",), $_modules);
}

function registerModules($_subpaths, $_register){
    /**
     * 加载所需使用的php脚本
     */
    foreach($_register as $_){
        foreach($_subpaths as $_subpath){
            $_file = "./application/".$_subpath."/".$_.".php";
            if(file_exists($_file)){
                include_once $_file;
            }
        }
    }
}



?>