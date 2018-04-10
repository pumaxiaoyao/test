<?php
namespace App\Controllers;
use App\Controllers\PlayerAPIController as PlayerAPI;
use App\Core\View;
use Gregwar\Captcha\CaptchaBuilder;

class HelpController extends BaseController{

    public static function default($request)
    {
        $showId = \getArrayValue("id", 1, $request);
        $factory = View::getView();
        $pageArgs = PlayerAPI::makePageArgs();
        $pageArgs["ID"] = $showId;
        return $factory->make('Help.helpDeposit.layout', $pageArgs)
            ->render();
    }

    public static function helpText($request)
    {
        $showId = \getArrayValue("subpage", 1, $request);
        $factory = View::getView();
        return $factory->make('Help.helpDeposit.helpText' . $showId)
            ->render();
    }

    public static function getCaptcha($request)
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
}