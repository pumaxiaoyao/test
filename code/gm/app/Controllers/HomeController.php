<?php
namespace App\Controllers;

use App\Config\Config;
use App\Controllers\Def;
use App\Controllers\HomeAPIController as HomeAPI;
use App\Core\View;
use Gregwar\Captcha\CaptchaBuilder;

class HomeController extends BaseController
{
    /**
     * GM-登录界面
     */
    public static function login($request)
    {
        $factory = View::getView();
        return $factory->make('Home.login.login', [])
            ->render();
    }

    /**
     * 获取验证码
     */
    public static function getCaptcha()
    {
        $builder = new CaptchaBuilder();
        $builder->build($width = 100, $height = 40, $font = null);
        //获取验证码的内容
        $phrase = $builder->getPhrase();

        //把内容存入session
        $_SESSION['validCaptcha'] = $phrase;
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();   
    }

    /**
     * 后台首页
     */
    public static function index($request)
    {
        $factory = View::getView();
        $pageArgs = [
            "sysMessageList" => []
        ];
        return $factory->make('Home.index.layout', $pageArgs)
            ->render();
    }

    /**
     * 获取账号密码加密RSA参数
     */
    public static function vpkey($request)
    {
        
    }

        
    /**
     * 构建图表内容Html
     *
     * @param [type] $chartName 图形控件名
     * @param [type] $chartData 图表数据
     *
     * @return void
     */
    private static function makeChartHtml($chartName, $chartData)
    {
        $factory = View::getView();
        $pageArgs = [
            "chartName" => $chartName,
            "chartData" => $chartData
        ];
        return $factory->make('Home.index.charts', $pageArgs)
            ->render();
    }


    public static function dw($request)
    {
        return self::makeChartHtml("theDWCharts", file_get_contents("./app/Views/Home/chartTestJson/dw.json"));
    }

    public static function betdaily($request)
    {
        return self::makeChartHtml("theBetdailyCharts", file_get_contents("./app/Views/Home/chartTestJson/betdaily.json"));
    }
    public static function cost($request)
    {
        return self::makeChartHtml("theCostCharts", file_get_contents("./app/Views/Home/chartTestJson/cost.json"));
    }
    public static function newplayer($request)
    {
        return self::makeChartHtml("theNEWCharts", file_get_contents("./app/Views/Home/chartTestJson/newplayer.json"));
    }
    public static function bet($request)
    {
        return self::makeChartHtml("theBetCharts", file_get_contents("./app/Views/Home/chartTestJson/bet.json"));
    }

    public static function wltotal($request)
    {
        return self::makeChartHtml("theWinLoseTotalCharts", file_get_contents("./app/Views/Home/chartTestJson/wltotal.json"));
    }

    public static function getInfo($request)
    {
        return file_get_contents("./app/Views/Home/chartTestJson/getInfo.json");
    }
    
}