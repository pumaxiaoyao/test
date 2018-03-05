<?php
/**
 * 通用的界面构建方法
 * php version 7.1
 *
 * @category GmViewHelper
 * @package  GM
 * @author   alien <email@email.com>
 * @license  Public http://alien.com
 * @link     http://alien.com
 */

/**
 * 显示登录界面
 *
 * @return void
 */
function makeLoginPage()
{
    return readHtml("login");
}

/**
 * 显示导航条Html
 *
 * @return void
 */
function makeNavPage()
{
    $_html = readHtml("common/common_nav");
    $s_class = "%class_" . getSessionValue("PageClass", "") . "%";
    $s_method = "%method_" . getSessionValue("PageMethod", "") . "%";
    $NavClassKeys = array("index");
    foreach (scandir("./application/controllers/zh-cn") as $_file) {
        if ($_file == "." || $_file == "..") {
            continue;
        }
        $fn = explode(".php", $_file)[0];
        if (!empty($fn)) {
            array_push($NavClassKeys, $fn);
        }
    }

    $NavMethodKeys = array("online", "allroles", "regdaily",
        "fundflow", "dptverify", "dpthistory", "dptcorrection",
        "wtdverify", "wtdhistory", "flowlimit", "transferList",
        "activity", "activityverify", "playerlevel", "agentlevel",
        "gplist", "csdept", "csacct", "ws", "wagered", "grant",
        "history", "verify", "aglist", "verifyhistory", "domain", "curperiod",
        "settlehistory", "agentwtdverify", "agentwtdhistory");
    foreach ($NavClassKeys as $_class) {
        $_class = "%class_" . $_class . "%";
        if (strtolower($_class) == strtolower($s_class)) {
            $replace_str = "start active open";
        } else {
            $replace_str = "";
        }
        $_html = str_replace(strtolower($_class), $replace_str, $_html);
    }
    foreach ($NavMethodKeys as $_method) {
        $_method = "%method_" . $_method . "%";
        if (strtolower($_method) == strtolower($s_method)) {
            $replace_str = "active";
        } else {
            $replace_str = "";
        }
        $_html = str_replace(strtolower($_method), $replace_str, $_html);
    }
    return $_html;

}

/**
 * 显示页面头部Html
 *
 * @param [type] $headtpl Html文件名
 *
 * @return void
 */
function makeHeaderPage($headtpl)
{
    if ($headtpl === null) {
        $Header = "";
    } else {
        $Header = readHtml('common/common_header');
        if (strlen($headtpl) > 0) {
            // 替换额外的header脚本
            $_hsc = readHtml('common/headers/' . $headtpl);
            $Header = str_replace('%HeaderScriptContent%', $_hsc, $Header);
        }
        $waitReplace = array(
            "Title" => "%TITLE%",
            "Account" => "%NICKNAME%",
            "TotalBalance" => "%TOTALBALANCE%",
        );
        foreach ($waitReplace as $_key => $_value) {
            $Header = str_replace($_value, getSessionValue($_key, "GM管理"), $Header);
        }
    }
    return $Header . makeNavPage();
}

/**
 * 构建页面脚部Html
 *
 * @param [type] $foottpl Footer页面内容
 *
 * @return void
 */
function makeFooterPage($foottpl)
{
    if ($foottpl === null) {
        $Footer = "";
    } else {
        $Footer = readHtml('common/common_footer');
        if (strlen($foottpl) > 0) {
            $_fsc = readHtml('common/footers/' . $foottpl);
        } else {
            $_fsc = "";
        }
        $Footer = str_replace('%FooterScriptContent%', $_fsc, $Footer);
    }
    return $Footer;
}

/**
 * 构建图表内容Html
 *
 * @param [type] $chartname 图形控件名
 * @param [type] $chartdata 图表数据
 *
 * @return void
 */
function makeChartHtml($chartname, $chartdata)
{
    $HtmlTemlate = readHtml("charts/chartsTemplate");
    $page = str_replace("%CHARTNAME%", $chartname, $HtmlTemlate);
    $page = str_replace("%CHARTDATA%", $chartdata, $page);
    output($page);
}

/**
 * 显示首页Html
 *
 * @return void
 */
function showIndex()
{
    $page = array(
        makeHeaderPage(""),
        readHtml("index"),
        makeFooterPage(""),
    );
    output(join("", $page));
}
