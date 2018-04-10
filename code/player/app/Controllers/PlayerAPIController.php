<?php

namespace App\Controllers;

use App\Config\Config;
use App\Libs\HttpRequest as http;

class PlayerAPIController extends BaseController
{

    /**
     * 检查用户名是否可用
     */
    public static function nameCheck($request)
    {
        $account = $request["MemberName"];
        if (!$account) {
            return [false];
        }
        return http::playerHttpCaller("CheckAccount", [$account]);
    }

    /**
     * 注册玩家的接口
     */
    public static function registerAccount($request)
    {
        $account = $request["memberName"];
        $password = $request["password"];

        if (!$account || !$password) {
            return [false, "valid arguments"];
        } else {
            $retJson = http::playerHttpCaller("Join", [$account, $password, getIp()]);
            if ($retJson[0]) {
                // 注册成功后，直接跳转登录接口
                return self::doLogin($account, $password);
            } else {
                LoginReset("player", false);
            }
        }
    }

    /**
     * 登录操作的实际执行方法
     */
    private static function doLogin($account, $passwd)
    {
        $domain = $_SERVER['SERVER_NAME'];
        $session = session_id();
        $retJson = http::playerHttpCaller("Login", [$account, $passwd, $session, getIp(), $domain, "HTML"]);
        if ($retJson[0]) {
            // 登录成功后，记录玩家的关键数据到session
            $_SESSION["PlayerName"] = $account;
            $_SESSION["PlayerSessionID"] = $session;
        } else {
            LoginReset("player", false);
        }
        return $retJson;
    }

    /**
     * 构建blade界面所需的参数组
     */
    public static function makePageArgs()
    {
        static $toSafetyLv = [
            4 => "高",
            3 => "中",
            2 => "中",
            1 => "低",
            0 => "低",
        ];

        $session = getSessionValue("PlayerSessionID", "");

        $t1 = [
            'title' => 'Alien', // TODO: 可抽离配置，根据页面配置不同的title传入blade
            "LoginStatus" => !$session ? "False" : "True",
            "LoginMemberName" => isset($_SESSION["PlayerName"]) ? $_SESSION["PlayerName"] : "",
        ];

        $defaultRet = [false, false, false, false, false, false, false];
        $ret = (!$session) ? $defaultRet : http::playerHttpCaller("GetMainInfo", [$session]);
        // todo..
        $t3 = [$ret[1], $ret[2], $ret[3], $ret[4]];
        $lv = 0;
        foreach ($t3 as $_v) {
            if ($_v) {
                $lv++;
            }
        }

        //已经是登录状态时，就可以同步取一次后台数据
        $t2 = [
            "RealName" => $ret[1],
            "Email" => $ret[2],
            "Phone" => $ret[3],
            "isBindCard" => $ret[4],
            "MessageCount" => $ret[5],
            "MainBalance" => $ret[6],
            "BankCards" => [],
            "AccountSafetyLevel" => $toSafetyLv[$lv],
        ];

        return array_merge($t1, $t2);
    }

    /**
     * 构建用户中心界面blade所需的数据
     */
    public static function makeASPageArgs()
    {
        $pageArgs = self::makePageArgs();

        $as_vars = [
            //设置用户中心的几个验证码有效时间管理
            "PhoneCodeInterval" => getSessionValue("GetPhoneCodeTime", 0) + 60 - time(),
            "unPhoneCodeInterval" => getSessionValue("GetUnPhoneCodeTime", 0) + 60 - time(),
            "EMailCodeInterval" => getSessionValue("GetMailCodeTime", 0) + 60 - time(),
            "unEMailCodeInterval" => getSessionValue("GetUnMailCodeTime", 0) + 60 - time(),
        ];
        return array_merge($pageArgs, $as_vars);
    }

    /**
     * 跳转首页的方法处理
     */
    private static function redirectToLogin()
    {
        header("location:/player/login");
    }

    /**
     * 跳转用户设置中心
     */
    private static function redirectToAccountSetting()
    {
        header("location:/player/accountSetting");
    }

    /**
     * 登录
     */
    public static function login($request)
    {
        $action = $request["action"];

        if ($action == "logout") {
            $loginSession = getSessionValue("PlayerSessionID", "");
            $ret = http::playerHttpCaller("Logout", array($loginSession));
            LoginReset();
            return [$ret];
        } elseif ($action === "login") {
            $account = $request["memberName"];
            $passwd = $request["memberPWD"];
            if (!$account || !$passwd) {
                LoginReset();
            } else {
                $retJson = self::doLogin($account, $passwd);
                return $retJson;
            }
        } else {
            self::redirectToLogin();
        }
    }

    /**
     * 用户中心-更新名字
     */
    private static function asUpdateName($request)
    {
        $FirstName = $request["FirstName"];
        $isFristName = $request["isFristName"];

        $realname = !$FirstName ? $isFristName : $FirstName;

        return http::playerHttpCaller("ModifyBaseInfo", [$request["loginSession"], urldecode($realname)]);
    }

    /**
     * 用户中心-更新密码
     */
    private static function asUpdatePwd($request)
    {
        $oldPassword = $request["oldPassword"];
        $Password = $request["Password"];
        $rePassword = $request["rePassword"];

        if (!$oldPassword || !$Password || !$rePassword) {
            return [false, "pwderror"];
        }

        if ($Password != $rePassword) {
            return [false, "pwdinvalid"];
        }

        return http::playerHttpCaller("ModifyPwd", [$request["loginSession"], $oldPassword, $Password]);
    }

    /**
     * 用户中心-获取手机验证码
     */
    private static function asGetPhoneCode($request)
    {
        $phoneNumber = $request["phoneNumber"];
        if (!$phoneNumber) {
            return [false, "error"];
        } else {
            $interval = getSessionValue("GetPhoneCodeTime", 0) + 60 - time();
            if ($interval < 0) {
                $_SESSION["WaitedBindPlayerPhone"] = $phoneNumber;
                $_SESSION["WaitedBindPhoneCode"] = (string) rand(1000, 9999);
                $_SESSION["GetPhoneCodeTime"] = time();
                return [true, "你的验证码是" . $_SESSION["WaitedBindPhoneCode"]];
            } else {
                return [false, "请等待" . $interval . "后再请求验证码", "Time" => $interval];
            }
        }
    }

    /**
     * 用户中心-校验手机验证码
     */
    private static function asCheckPhoneCode($request)
    {
        $session = $request["loginSession"];
        // 请求验证的验证码
        $phoneCode = $request["phoneCode"];
        // Session中的验证码
        $sessionCode = $_SESSION["WaitedBindPhoneCode"];
        // Session中的待绑定手机
        $sessionPhone = $_SESSION["WaitedBindPlayerPhone"];

        if ($phoneCode == $sessionCode) {
            $_SESSION["GetPhoneCodeTime"] = 0;
            //修改手机号码
            $retJson = http::playerHttpCaller("ModifyCellPhoneNo", [$session, $sessionPhone]);
            if ($retJson[0]) {
                return [true, "绑定手机号码修改成功"];
            } else {
                return [false, "绑定手机号码修改失败"];
            }
        } else {
            return [false, "验证失败，请重新输入您的验证码"];
        }
    }

    /**
     * 用户中心-获取解绑手机验证码
     */
    private static function asGetUnPhoneCode($request)
    {
        /**
         * 下发校验码，缓存在session中
         */
        $interval = getSessionValue("GetUnPhoneCodeTime", 0) + 60 - time();
        if ($interval < 0) {
            $_SESSION["WaitedUnBindPhoneCode"] = (string) rand(1000, 9999);
            $_SESSION["GetUnPhoneCodeTime"] = time();
            return [true, "解绑手机的验证码为" . $_SESSION["WaitedUnBindPhoneCode"]];
        } else {
            return [false, "请等待" . $interval . "后再请求验证码", "Time" => $interval];
        }
    }

    /**
     * 用户中心-解绑手机
     */
    private static function asUnbindPhone($request)
    {
        /**
         * 解绑手机号码，校验session中预存的验证码
         */
        $phoneCode = $request["phoneCode"];
        if ($phoneCode == $_SESSION["WaitedUnBindPhoneCode"]) {
            $_SESSION["GetUnPhoneCodeTime"] = 0;
            $retJson = http::playerHttpCaller("ModifyCellPhoneNo", [$request["loginSession"], ""]);
            if ($retJson[0]) {
                return [true, "解绑手机号码成功"];
            } else {
                return [true, "解绑手机号码失败，请联系客服"];
            }
        } else {
            return [true, "验证失败，请重新输入您的验证码"];
        }
    }

    /**
     * 用户中心-获取解绑邮件验证码
     */
    private static function asGetUnEmailCode($request)
    {
        /**
         * 下发校验码，缓存在session中
         */
        $interval = getSessionValue("GetUnMailCodeTime", 0) + 60 - time();
        if ($interval < 0) {
            $_SESSION["WaitedUnBindEmailCode"] = (string) rand(1000, 9999);
            $_SESSION["GetUnMailCodeTime"] = time();
            return [true, "解绑手机的验证码为" . $_SESSION["WaitedUnBindEmailCode"]];
        } else {
            return [false, "请等待" . $interval . "后再请求验证码", "Time" => $interval];
        }
    }

    /**
     * 用户中心-获取绑定邮件验证码
     */
    private static function asGetEmailCode($request)
    {
        $mailNumber = $request["mailNumber"];
        if (!$mailNumber) {
            return [false, "error"];
        } else {
            $interval = getSessionValue("GetMailCodeTime", 0) + 60 - time();
            if ($interval < 0) {
                $_SESSION["WaitedBindPlayerEmail"] = urldecode($mailNumber);
                $_SESSION["WaitedBindEmailCode"] = (string) rand(1000, 9999);
                $_SESSION["GetMailCodeTime"] = time();
                return [true, "你的验证码是" . $_SESSION["WaitedBindEmailCode"]];
            } else {
                return [false, "请等待" . $interval . "后再请求验证码", "Time" => $interval];
            }
        }
    }

    /**
     * 用户中心-校验邮件验证码
     */
    private static function asCheckEmailCode($request)
    {
        $emailCode = $request["emailCode"];
        $session = $request["loginSession"];
        if ($emailCode == $_SESSION["WaitedBindEmailCode"]) {
            //修改手机号码
            $_SESSION["GetMailCodeTime"] = 0;
            $retJson = http::playerHttpCaller("ModifyEmail", [$session, $_SESSION["WaitedBindPlayerEmail"]]);
            if ($retJson[0]) {
                return [true, "绑定邮箱地址修改成功"];
            } else {
                return [true, "绑定邮箱地址修改失败"];
            }
        } else {
            return [true, "验证失败，请重新输入您的验证码"];
        }
    }

    /**
     * 用户中心-解绑邮件
     */
    private static function asUnBindEmail($request)
    {
        $emailCode = $request["emailCode"];
        if ($emailCode == $_SESSION["WaitedUnBindEmailCode"]) {
            $_SESSION["GetUnMailCodeTime"] = 0;
            $retJson = http::playerHttpCaller("ModifyEmail", array($request["loginSession"], ""));
            if ($retJson[0]) {
                return [true, "解绑邮箱地址成功"];
            } else {
                return [false, "解绑邮箱地址失败，请联系客服"];
            }
        } else {
            return [false, "验证失败，请重新输入您的验证码"];
        }
    }

    /**
     * 用户中心的操作接口
     */
    public static function accountSetting($request)
    {
        $loginSession = getSessionValue("PlayerSessionID", "");
        $request["loginSession"] = $loginSession;
        $action = $request["action"];
        if (count($request) == 0 || !isset($request["action"]) || empty($request["action"])) {
            self::redirectToAccountSetting();
            return [false];
        }
        // 方法映射, 从用户中心接口统一调用
        $actionMap = [
            "updateinformation" => "asUpdateName",
            "updatePassword" => "asUpdatePwd",
            "getPhoneCode" => "asGetPhoneCode",
            "CheckPhoneCode" => "asCheckPhoneCode",
            "getUnPhoneCode" => "asGetUnPhoneCode",
            "UnBindPhone" => "asUnbindPhone",
            "getUnEmailCode" => "asGetUnEmailCode",
            "getEmailCode" => "asGetEmailCode",
            "CheckEmailCode" => "asCheckEmailCode",
            "UnBindEmail" => "asUnBindEmail",
        ];
        return call_user_func_array(
            ["App\Controllers\PlayerAPIController", $actionMap[$action]],
            [$request]
        );
    }

    /**
     * 获取邮件数据
     */
    public static function getMailData($pageIndex)
    {
        $loginSession = getSessionValue("PlayerSessionID", "");
        $ret = http::playerHttpCaller("GetMessages", array($loginSession));
        if ($ret[0]) {
            return $ret[1];
        } else {
            return [];
        }
    }

    /**
     * 获取邮件详情数据
     */
    public static function getMailDetailData($mailId)
    {
        $loginSession = getSessionValue("PlayerSessionID", "");
        return http::playerHttpCaller("ReadMessage", array($loginSession, $mailId));
    }

    /**
     * 获取投注记录数据
     */
    public static function getBetRecordData($startTime)
    {
        $loginSession = getSessionValue("PlayerSessionID", "");
        $st = [
            "today" => time() - 24 * 60 * 60,
            "3day" => time() - 24 * 60 * 60 * 3,
            "week" => time() - 24 * 60 * 60 * 7,
            "month" => time() - 24 * 60 * 60 * 30,
        ];

        $betRecords = [];
        foreach (Config::platform as $gpId => $gpName) {
            $retJson = http::playerHttpCaller("GetBetRecord", array($loginSession, $gpId, 0, $st[$startTime]));
            $betRecords[$gpId] = [
                "data" => $retJson[0],
                "name" => $gpName,
            ];
        }
        return $betRecords;
    }

    /**
     * 获取银行信息
     */
    public static function getBankInfo()
    {
        $loginSession = getSessionValue("PlayerSessionID", "");
        $retJson = http::playerHttpCaller("GetBankCardInfo", array($loginSession));
        return $retJson[1];
    }

    /**
     * 获取银行卡验证码
     */
    public static function getBankCode($request)
    {
        $_SESSION["WaitedBindCardCode"] = (string) rand(1000, 9999);
        return [true, "你的验证码是" . $_SESSION["WaitedBindCardCode"]];
    }

    /**
     * 获取交易记录
     */
    public static function getTransctRecords($optype, $st)
    {
        $loginSession = getSessionValue("PlayerSessionID", "");
        $tt = [
            "today" => time() - 24 * 60 * 60,
            "3day" => time() - 24 * 60 * 60 * 3,
            "week" => time() - 24 * 60 * 60 * 7,
            "month" => time() - 24 * 60 * 60 * 30,
        ];
        $retJson = http::playerHttpCaller("GetBalanceRecord", [$loginSession, $optype, $tt[$st], time(), 1, 9999]);
        if ($retJson[0]) {
            return $retJson[1];
        } else {
            return [];
        }
    }

    /**
     * 添加银行卡
     */
    public static function addBankCard($request)
    {
        $loginSession = getSessionValue("PlayerSessionID", "");
        $RealName = getArrayValue("RealName", "", $request);
        $BankNo = getArrayValue("BankNo", "", $request);
        $BankType = getArrayValue("BankType", "", $request);
        $RegBank = getArrayValue("RegBank", "", $request);
        $code = getArrayValue("code", "", $request);
        if (empty($BankNo) || empty($BankType) || empty($RegBank) || empty($code) || empty($RealName)) {
            return [false, "参数提交错误"];
        }

        if ((int) $code != (int) getSessionValue("WaitedBindCardCode", 0)) {
            return [false, "请输入正确的验证码"];
        }
        $retJson = http::playerHttpCaller("AddBankCard", array($loginSession, $BankType, $RealName, $BankNo, $RegBank));
        return $retJson;
    }

    /**
     * 删除银行卡
     */
    public static function delBankCard($request)
    {
        $loginSession = getSessionValue("PlayerSessionID", "");
        $cardIndex = getArrayValue("index", "", $request);
        if (empty($cardIndex)) {
            return [false];
        }
        $retJson = http::playerHttpCaller("DeleteBankCard", array($loginSession, (int) $cardIndex));
        return $retJson;
    }

    /**
     * 取款操作
     */
    public static function withdrawalCash($request)
    {
        $loginSession = getSessionValue("PlayerSessionID", "");
        $CardIdx = (int)$request["bank"]; //getArrayValue("bank", 1, $request);
        $Amount = (float)$request["amount"];
        $Action = getArrayValue("action", "create", $request);
        return http::playerHttpCaller("ApplyWithdrawal", array($loginSession, $Amount, $CardIdx));
    }
}
