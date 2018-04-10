<?php
namespace App\Controllers;

use App\Config\Config;
use App\Config\IBCConfig;
use App\Config\NBConfig;
use App\Core\View;
use App\Libs\HttpRequest as http;

class AgentAPIController extends BaseController
{
    public static function makePageArgs()
    {
        $LoginStatus = getSessionValue("AgentLoginStatus", "False");
        $MemberName = getSessionValue("AgentName", "");
        $loginSession = getSessionValue("AgentSessionID", "");
        $t = [
            'title' => 'Alien', // 可以抽离根据页面配置不同的title传入blade
            "LoginStatus" => !$loginSession ? "False" : $LoginStatus,
            "LoginMemberName" => $MemberName,
        ];

        $ret = (empty($loginSession)) ? [] : http::agentHttpCaller("GetMainInfo", array($loginSession));
        // if ($ret && $ret[0])
        $ret = ($ret && $ret[0]) ? $ret[1] : [];
        //已经是登录状态时，就可以同步取一次后台数据
        $t["RealName"] = getArrayValue("name", "", $ret);
        $t["Email"] = getArrayValue("email", "", $ret);
        $t["Phone"] = getArrayValue("cellPhoneNo", "", $ret);
        $t["isBindCard"] = getArrayValue("isBindBankCard", "", $ret);
        $t["MessageCount"] = getArrayValue("newMessageCount", "", $ret);
        $t["MainBalance"] = getArrayValue("balance", "", $ret);
        $t["lvl"] = getArrayValue("lvl", "", $ret);
        $t["BankCards"] = [];
        return $t;
    }

    public static function makeASPageArgs()
    {
        $pageArgs = self::makePageArgs();
        $as_vars = [
            "PhoneCodeInterval" => getSessionValue("GetPhoneCodeTime", 0) + 60 - time(),
            "unPhoneCodeInterval" => getSessionValue("GetUnPhoneCodeTime", 0) + 60 - time(),
            "EMailCodeInterval" => getSessionValue("GetMailCodeTime", 0) + 60 - time(),
            "unEMailCodeInterval" => getSessionValue("GetUnMailCodeTime", 0) + 60 - time(),
        ];
        return array_merge($pageArgs, $as_vars);
    }

    public static function checkAgentName($request)
    {
        $agName = getArrayValue("aname", "", $request);
        if (empty("agName")) {
            return [false];
        } else {
            $retJson = http::agentHttpCaller("CheckAccount", array($agName));

            if ($retJson[0]) {
                return ["FORCETOTEXT", "true"];
            } elseif ($retJson[1] == "accountAlreadyExist") {
                return [false, "用户名已存在"];
            } else {
                return [false];
            }

        }
    }

    private static function aregValidor($request)
    {
        $agName = getArrayValue("aname", "", $request);
        $agPwd = getArrayValue("apwd", "", $request);
        $agPwd1 = getArrayValue("password1", "", $request);
        $agRealname = getArrayValue("realname", "", $request);
        $agEmail = getArrayValue("email", "", $request);
        $agPhone = getArrayValue("aphone", "", $request);
        $agQQ = getArrayValue("qq", "", $request);
        $verifycode = getArrayValue("verifycode", "", $request);
        $iagree = getArrayValue("iagree", "", $request);
        if ($iagree != 1) {
            return [false, "需要点击同意合营条款和条件才可继续操作"];
        } elseif ($agPwd != $agPwd1) {
            return [false, "2次输入的密码不一致，请重新输入"];
        } elseif (\getSessionValue("validCaptcha", "") != $verifycode) {
            return [false, "验证码校验失败，请重新输入"];
        } elseif (empty($agName) || empty($agPwd) || empty($agRealname) || empty($agPhone) || empty($agEmail)) {
            return [false, "信息输入不全"];
        } else {
            $args = [$agName, $agPwd, $agRealname, $agEmail, $agPhone, $agQQ, getIp()];
            return [true, $args];
        }
    }

    /**
     * 代理注册的接口
     *
     * @param [type] $request
     * @return void
     */
    public static function agentReg($request)
    {
        $reginfo = self::aregValidor($request);
        if (!$reginfo[0]) {
            return $reginfo;
        } else {
            $retJson = http::agentHttpCaller("Join", $reginfo[1]);
        }

        if ($retJson[0]) {
            return [true, true, $retJson];
        } else {
            return [true, false, "注册失败"];
        }

    }

    /**
     * 次级代理注册的接口
     *
     * @param [type] $request URI参数
     * @return void
     */
    public static function agentClientReg($request)
    {
        $reginfo = self::aregValidor($request);
        $loginSession = getSessionValue("AgentSessionID", "");
        if (!$reginfo[0]) {
            return $reginfo;
        } else {
            $args = $reginfo[1];
        }

        array_unshift($args, $loginSession);
        $retJson = http::agentHttpCaller("CreateChildAgent", $args);
        if ($retJson[0]) {
            return [true, true, $retJson];
        } else {
            return [true, false, "注册失败"];
        }
    }

    private static function redirectToLogin()
    {
        header("location:/agent/index");
    }
    /**
     * 代理登录
     *
     * @param [type] $request URI
     *
     * @return void
     */
    public static function login($request)
    {
        if (count($request) == 0) {
            //参数为空，则不予登录
            PlayerAPIController::redirectToLogin();
            return [false];
        }

        $action = getArrayValue("action", null, $request);

        $account = getArrayValue("aname", "", $request);
        $passwd = getArrayValue("apwd", "", $request);
        if (empty($account) || empty($passwd)) {
            LoginReset("agent", true);
        } else {
            return AgentAPIController::doLogin($account, $passwd);
        }

    }

    private static function doLogin($account, $passwd)
    {
        /**
         * 执行login操作
         */
        $retJson = http::agentHttpCaller("Login", array($account, $passwd, session_id(), getIp()));
        if ($retJson[0]) {
            $_SESSION["AgentName"] = $account;
            $_SESSION["AgentLoginStatus"] = "True";
            $_SESSION["AgentSessionID"] = session_id();
        } else {
            LoginReset("agent", false);
        }
        return $retJson;
    }

    /**
     * 代理登出，清除缓存信息
     *
     * @param [type] $request
     * @return void
     */
    public static function logout($request)
    {
        $loginSession = getSessionValue("AgentSessionID", "");
        // if (!$loginSession) {
        http::agentHttpCaller("Logout", array($loginSession));
        // }
        LoginReset("agent", false);
        return [true];
    }

    public static function RefreshBalance($request)
    {
        /**
         * 刷新账号余额信息
         */
        $partner = getArrayValue("partnerCode", "", $request);
        if (count($request) == 0) {
            return [false, "未提交参数"];
        }

        if (empty($partner)) {
            return [false, "提交的参数错误"];
        }

        $loginSession = getSessionValue("AgentSessionID", "");

        $retJson = http::agentHttpCaller("GetBalanceAmount", array($loginSession)); //, $partner));
        if ($retJson[0]) {
            $_SESSION["Balance"] = $retJson[1];
        }

        return $retJson;
    }

    /**
     * 用户中心的操作接口
     */
    public static function AccountSetting($request)
    {
        $loginSession = getSessionValue("AgentSessionID", "");
        $request["loginSession"] = $loginSession;
        $action = getArrayValue("action", null, $request);
        if (count($request) == 0 || !isset($request["action"]) || empty($request["action"])) {
            AgentAPIController::redirectToAccountSetting();
            return [false];
        }
        $actionMap = [
            "updateinformation" => "as_updateinformation",
            "updatePassword" => "as_UpdatePassword",
            "getPhoneCode" => "as_getPhoneCode",
            "CheckPhoneCode" => "as_CheckPhoneCode",
            "getUnPhoneCode" => "as_getUnPhoneCode",
            "UnBindPhone" => "as_UnBindPhone",
            "getUnEmailCode" => "as_getUnEmailCode",
            "getEmailCode" => "as_getEmailCode",
            "CheckEmailCode" => "as_CheckEmailCode",
            "UnBindEmail" => "as_UnBindEmail",
        ];
        return call_user_func_array(
            ["App\Controllers\AgentAPIController", $actionMap[$action]], [$request]
        );
    }

    private static function as_UnBindEmail($request)
    {
        /**
         * 解绑手机号码，校验session中预存的验证码
         */
        $emailCode = getArrayValue("emailCode", "", $request);
        if ($emailCode == $_SESSION["WaitedUnBindEmailCode"]) {
            $_SESSION["GetUnMailCodeTime"] = 0;
            $retJson = http::agentHttpCaller("ModifyEmail", array($request["loginSession"], ""));
            if ($retJson[0]) {
                return [true, "解绑邮箱地址成功"];
            } else {
                return [false, "解绑邮箱地址失败，请联系客服"];
            }

        } else {
            return [false, "验证失败，请重新输入您的验证码"];
        }

    }

    private static function as_CheckEmailCode($request)
    {
        $emailCode = getArrayValue("emailCode", "", $request);
        if ($emailCode == $_SESSION["WaitedBindEmailCode"]) {
            //修改手机号码
            $_SESSION["GetMailCodeTime"] = 0;
            $retJson = http::agentHttpCaller("ModifyEmail", array($request["loginSession"], $_SESSION["WaitedBindPlayerEmail"]));
            if ($retJson[0]) {
                return [true, "绑定邮箱地址修改成功"];
            } else {
                return [true, "绑定邮箱地址修改失败"];
            }

        } else {
            return [true, "验证失败，请重新输入您的验证码"];
        }

    }

    private static function as_getEmailCode($request)
    {
        $mailNumber = getArrayValue("mailNumber", "", $request);
        if (empty($mailNumber)) {
            return [false, "error"];
        } else {
            $interval = getSessionValue("GetMailCodeTime", 0) + 60 - time();
            if ($interval < 0) {
                $_SESSION["WaitedBindPlayerEmail"] = $mailNumber;
                $_SESSION["WaitedBindEmailCode"] = (string) rand(1000, 9999);
                $_SESSION["GetMailCodeTime"] = time();
                return [true, "你的验证码是" . $_SESSION["WaitedBindEmailCode"]];
            } else {
                return [false, "请等待" . $interval . "后再请求验证码", "Time" => $interval];
            }

        }
    }

    private static function as_getUnEmailCode($request)
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

    private static function as_UnBindPhone($request)
    {
        /**
         * 解绑手机号码，校验session中预存的验证码
         */
        $phoneCode = getArrayValue("phoneCode", "", $request);
        if ($phoneCode == $_SESSION["WaitedUnBindPhoneCode"]) {
            $_SESSION["GetUnPhoneCodeTime"] = 0;
            $retJson = http::agentHttpCaller("ModifyCellPhoneNo", array($request["loginSession"], ""));
            if ($retJson[0]) {
                return [true, "解绑手机号码成功"];
            } else {
                return [true, "解绑手机号码失败，请联系客服"];
            }

        } else {
            return [true, "验证失败，请重新输入您的验证码"];
        }

    }

    private static function as_getUnPhoneCode($request)
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

    private static function as_CheckPhoneCode($request)
    {
        $phoneCode = getArrayValue("phoneCode", "", $request);
        if ($phoneCode == $_SESSION["WaitedBindPhoneCode"]) {
            $_SESSION["GetPhoneCodeTime"] = 0;
            //修改手机号码
            $retJson = http::agentHttpCaller("ModifyCellPhoneNo", array($request["loginSession"], $_SESSION["WaitedBindPlayerPhone"]));
            if ($retJson[0]) {
                return [true, "绑定手机号码修改成功"];
            } else {
                return [false, "绑定手机号码修改失败"];
            }

        } else {
            return [false, "验证失败，请重新输入您的验证码"];
        }

    }

    private static function as_getPhoneCode($request)
    {
        $phoneNumber = getArrayValue("phoneNumber", "", $request);
        if (empty($phoneNumber)) {
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

    private static function as_UpdatePassword($request)
    {
        $oldPwd = getArrayValue("oldPassword", "", $request);
        $Pwd = getArrayValue("Password", "", $request);
        $rePwd = getArrayValue("rePassword", "", $request);
        if (empty($oldPwd)) {
            return [false, "pwderror"];
        }

        if (empty($Pwd) || empty($rePwd)) {
            return [false, "emptypwd"];
        }

        if ($Pwd != $rePwd) {
            return [false, "pwdinvalid"];
        }

        return http::agentHttpCaller("ModifyPwd", array($request["loginSession"], $oldPwd, $Pwd));
    }

    private static function as_updateinformation($request)
    {
        $FirstName = getArrayValue("FirstName", "", $request);
        $isFristName = getArrayValue("isFristName", "", $request);

        $realname = !$FirstName ? $isFristName : $FirstName;

        $requestData = array($request["loginSession"], urldecode($realname));
        return http::agentHttpCaller("ModifyBaseInfo", $requestData);
    }

    public static function getBankInfo()
    {
        $loginSession = getSessionValue("AgentSessionID", "");
        $retJson = http::agentHttpCaller("GetBankCardInfo", array($loginSession));
        return $retJson[1];
    }

    public static function getBankCode($request)
    {
        $_SESSION["WaitedBindCardCode"] = (string) rand(1000, 9999);
        return [true, "你的验证码是" . $_SESSION["WaitedBindCardCode"]];
    }

    public static function addBankCard($request)
    {
        /**
         * 添加绑定用户的银行卡
         */
        $loginSession = getSessionValue("AgentSessionID", "");
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
        $retJson = http::agentHttpCaller("AddBankCard", array($loginSession, $BankType, $RealName, $BankNo, $RegBank));
        return $retJson;
    }

    public static function delBankCard($request)
    {
        /**
         * 删除用户绑定的银行卡
         */
        $loginSession = getSessionValue("AgentSessionID", "");
        $cardIndex = getArrayValue("index", "", $request);
        if (empty($cardIndex)) {
            return [false];
        }
        $retJson = http::agentHttpCaller("DeleteBankCard", array($loginSession, (int) $cardIndex));
        return $retJson;
    }

    public static function withdrawalCash($request)
    {
        $loginSession = getSessionValue("AgentSessionID", "");
        $CardIdx = (int) getArrayValue("bank", 1, $request);
        $Amount = (float) getArrayValue("amount", 0, $request, true);
        $Action = getArrayValue("action", "create", $request);
        return http::agentHttpCaller("ApplyWithdrawal", array($loginSession, $Amount, $CardIdx));
    }

    public static function wdHistoryAjax($request)
    {
        $loginSession = getSessionValue("AgentSessionID", "");
        $st = getArrayValue("startdate", "", $request);
        $st = empty($st) ? time() - 60 * 24 * 60 * 30 : strtotime($st);

        $et = getArrayValue("enddate", "", $request);
        $et = empty($et) ? time() : strtotime($et);

        $retJson = http::agentHttpCaller("GetBalanceRecord", array($loginSession, 1, $st, $et, 1, 999));

        if (getArrayValue(0, "", $retJson) == 1) {
            $retData = getArrayValue(1, "", $retJson)["data"];
        } else {
            $retData = [];
        }
        $pageArgs = [];
        foreach ($retData as $_history) {
            array_push($pageArgs, [
                "time" => parseDate(\getArrayValue("recordTime", "", $_history)),
                "dno" => getArrayValue("dno", "", $_history),
                "amount" => getArrayValue("amount", "", $_history),
                "wdfee" => getArrayValue("withdrawal_fee", "", $_history),
                "applyAmount" => getArrayValue("applyAmount", "", $_history),
                "checkStatus" => Config::statusMap[getArrayValue("checkStatus", "", $_history)],
                "note" => getArrayValue("note", "", $retData),
            ]);
        }
        $factory = View::getView();
        $wdHistoryHtml = $factory->make('Agent\AccountSetting\withdrawl\wdhistory', ["wdHistoryData" => $pageArgs])
            ->render();
        return [true, $wdHistoryHtml];
    }

    public static function agentInfoAjax($request)
    {
        $loginSession = getSessionValue("AgentSessionID", "");
        $retJson = http::agentHttpCaller("GetJointInfo", array($loginSession));
        $retJson = \getArrayValue(0, array(), $retJson);
        $roleId = "";
        if (count($retJson) > 0) {
            $roleId = getArrayValue("roleId", "", $retJson[0]);
        }

        $factory = View::getView();
        $_SESSION["aaa"] = $retJson;
        $domainHtml = $factory->make('Agent\AccountSetting\agentInfo\agentDomain', ["AgentDomains" => $retJson])
            ->render();
        return [true, $domainHtml, $roleId];
    }

    public static function getMailData($pageIndex)
    {
        $loginSession = getSessionValue("AgentSessionID", "");
        $ret = http::agentHttpCaller("GetMessages", array($loginSession));
        if ($ret[0]) {
            return $ret[1];
        } else {
            return [];
        }

    }

    public static function getMailDetailData($mailId)
    {
        $loginSession = getSessionValue("AgentSessionID", "");
        return http::agentHttpCaller("ReadMessage", array($loginSession, $mailId));
    }

    public static function benifitreportAjax($request)
    {
        $loginSession = getSessionValue("AgentSessionID", "");
        $retJson = http::agentHttpCaller("GetSettleStatement", array($loginSession));
        $retData = getArrayValue(0, array(), $retJson);
        $pageArgs = [];
        foreach ($retData as $_benifit) {
            array_push($pageArgs, [
                "month" => \getArrayValue("month", "", $_benifit),
                "validPlayerCount" => \getArrayValue("validPlayerCount", "", $_benifit),
                "platformCommision" => \getArrayValue("platformCommision", "", $_benifit),
                "costAllocation" => \getArrayValue("costAllocation", "", $_benifit),
                "lastMonthLeftAmount" => \getArrayValue("lastMonthLeftAmount", "", $_benifit),
                "adjustmentAmount" => \getArrayValue("adjustmentAmount", "", $_benifit),
                "commisionAmount" => \getArrayValue("commisionAmount", "", $_benifit),
                "commisionResultAmount" => \getArrayValue("commisionResultAmount", "", $_benifit),
                "checkStatus" => Config::statusMap[getArrayValue("status", "", $_benifit)],
            ]);
            $gcData = self::makeGameCommissionHtml($_benifit);
            $gcHtml = $gcData[0];

            $ccHtml = self::makeChildCommissionHtml($_benifit, $gcData[1]);
            $caHtml = self::makeChildCostAlloation($_benifit);
            if (!isset($_SESSION["GameCommision"])) {
                $_SESSION["GameCommision"] = array();
            }

            $_SESSION["GameCommision"][\getArrayValue("month", "", $_benifit)] = array("gc" => $gcHtml, "cc" => $ccHtml, "ca" => $caHtml);

        }
        $factory = View::getView();
        $benifitHtml = $factory->make('Agent\reports\benifitReports\benifitreport', ["benifitData" => $pageArgs])
            ->render();
        return [true, $benifitHtml];
    }

    /**
     * 生成成本分摊界面的Html
     *
     * @param [type] $data 数据
     *
     * @return void
     */
    public static function makeChildCostAlloation($data)
    {
        $caHtml = "";
        $childStr = getArrayValue("childStr", "", $data);

        $depositBonusAllocationAmount = (float) getArrayValue("depositBonusAllocationAmount", 0, $data);
        $depositBonusAmount = (float) getArrayValue("depositBonusAmount", 0, $data);
        $depositBonusRate = sprintf("%.2f", getArrayValue("depositBonusRate", 0, $data) * 100);

        $bonusAllocationAmount = (float) getArrayValue("bonusAllocationAmount", 0, $data);
        $bonusAmount = (float) getArrayValue("bonusAmount", 0, $data);
        $bonusRate = sprintf("%.2f", getArrayValue("bonusRate", 0, $data) * 100);

        $rebateAllocationAmount = (float) getArrayValue("rebateAllocationAmount", 0, $data);
        $rebateAmount = (float) getArrayValue("rebateAmount", 0, $data);
        $rebateRate = sprintf("%.2f", getArrayValue("rebateRate", 0, $data) * 100);
        // AgentAllocationData

        $caHtml = "<tr><th>" . $depositBonusAllocationAmount . "</th>";
        $caHtml .= "<th>" . $depositBonusRate . "%</th>";
        $caHtml .= "<th>" . $depositBonusAmount . "</th>";

        $caHtml .= "<th>" . $bonusAllocationAmount . "</th>";
        $caHtml .= "<th>" . $bonusRate . "%</th>";
        $caHtml .= "<th>" . $bonusAmount . "</th>";

        $caHtml .= "<th>" . $rebateAllocationAmount . "</th>";
        $caHtml .= "<th>" . $rebateRate . "%</th>";
        $caHtml .= "<th>" . $rebateAmount . "</th></tr>";

        $lineChargeRate = sprintf("%.2f", getArrayValue("lineChargeRate", 0, $data) * 100);

        $ccHtml = "";
        $totalDeposit = 0;
        $totalBonus = 0;
        $totalRebate = 0;
        if (!empty($childStr)) {
            $childData = json_decode($childStr, true);
            foreach ($childData as $cData) {
                $roleId = getArrayValue("roleId", "", $cData);

                $_depositBonusAllocationAmount = (float) getArrayValue("depositBonusAllocationAmount", 0, $cData);
                $_depositBonusAmount = (float) getArrayValue("depositBonusAmount", 0, $cData);
                $_depositBonusRate = sprintf("%.2f", getArrayValue("depositBonusRate", 0, $cData) * 100);

                $_bonusAllocationAmount = (float) getArrayValue("bonusAllocationAmount", 0, $cData);
                $_bonusAmount = (float) getArrayValue("bonusAmount", 0, $cData);
                $_bonusRate = sprintf("%.2f", getArrayValue("bonusRate", 0, $cData) * 100);

                $_rebateAllocationAmount = (float) getArrayValue("rebateAllocationAmount", 0, $cData);
                $_rebateAmount = (float) getArrayValue("rebateAmount", 0, $cData);
                $_rabateRate = sprintf("%.2f", getArrayValue("rabateRate", 0, $cData) * 100);

                $totalDeposit += $_depositBonusAllocationAmount;
                $totalBonus += $_bonusAllocationAmount;
                $totalRebate += $_rebateAllocationAmount;

                $ccHtml .= "<tr><td>" . $roleId . "</td>";
                $ccHtml .= "<td>" . $_depositBonusAllocationAmount . "</td>";
                $ccHtml .= "<td>" . $_depositBonusRate . "%</td>";
                $ccHtml .= "<td>" . $_depositBonusAmount . "</td>";
                $ccHtml .= "<td>" . $_bonusAllocationAmount . "</td>";
                $ccHtml .= "<td>" . $_bonusRate . "%</td>";
                $ccHtml .= "<td>" . $_bonusAmount . "</td>";
                $ccHtml .= "<td>" . $_rebateAllocationAmount . "</td>";
                $ccHtml .= "<td>" . $_rabateRate . "%</td>";
                $ccHtml .= "<td>" . $_rebateAmount . "</td></tr>";
            }

        }

        $ccHtml .= "<tr><td>实际承担费用</td>";
        $ccHtml .= "<td colspan=2>存款优惠</td>";
        $ccHtml .= "<td>" . ($depositBonusAllocationAmount - $totalDeposit) . "</td>";
        $ccHtml .= "<td colspan=2>红利</td>";
        $ccHtml .= "<td>" . ($bonusAllocationAmount - $totalBonus) . "</td>";
        $ccHtml .= "<td colspan=2>返水</td>";
        $ccHtml .= "<td>" . ($rebateAllocationAmount - $totalRebate) . "</td>";

        return array($caHtml, $ccHtml);
    }

    private static function makeChildCommissionHtml($data, $TotalCommision)
    {
        $ccHtml = "";
        $childStr = getArrayValue("childStr", "", $data);
        $lineChargeRate = sprintf("%.2f", getArrayValue("lineChargeRate", 0, $data) * 100);
        $totalLineCommision = 0;
        if (!empty($childStr)) {
            $childData = json_decode($childStr, true);

            foreach ($childData as $cData) {
                $roleId = getArrayValue("roleId", "", $cData);
                $commisionAmount = getArrayValue("pumpingCommisionAmount", 0, $cData);
                $waterAmount = getArrayValue("pumpingWaterAmount", 0, $cData);
                $totalAmount = $commisionAmount + $waterAmount;
                $lineAmount = getArrayValue("lineChargeAmount", 0, $cData);
                $totalLineCommision += $lineAmount;
                $ccHtml .= "<tr><td>" . $roleId . "</td>";
                $ccHtml .= "<td>" . $commisionAmount . "</td>";
                $ccHtml .= "<td>" . $waterAmount . "</td>";
                $ccHtml .= "<td>" . $totalAmount . "</td>";
                $ccHtml .= "<td>" . $lineChargeRate . "%</td>";
                $ccHtml .= "<td>" . $lineAmount . "</td></tr>";
            }
        }
        $ccHtml .= "<tr><td>代理线佣金</td>";
        $ccHtml .= "<td>" . $TotalCommision . "</td>";
        $ccHtml .= "<td>下线佣金合计</td>";
        $ccHtml .= "<td>" . $totalLineCommision . "</td>";
        $ccHtml .= "<td>实际结算佣金</td>";
        $ccHtml .= "<td>" . ($TotalCommision - $totalLineCommision) . "</td>";
        return $ccHtml;
    }

    private static function makeGameCommissionHtml($data)
    {
        $crHtml = "";
        $gameStr = getArrayValue("gameStr", "", $data);
        $TotalWinLose = 0;
        $TotalCommision = 0;
        $TotalWater = 0;
        $TotalStake = 0;
        $lineChargeRate = sprintf("%.2f", getArrayValue("lineChargeRate", 0, $data) * 100);
        $pageArgs = [];
        if (!empty($gameStr)) {
            $pageArgs["gameData"] = json_decode($gameStr, true);
            foreach ($pageArgs["gameData"] as $gpName => $gpData) {
                $TotalWinLose += (float) $gpData["winLoseAmount"];
                $TotalCommision += (float) $gpData["pumpingCommisionAmount"];
                $TotalWater += (float) $gpData["pumpingWaterAmount"];
                $TotalStake += (float) $gpData["validStakeAmount"];
            }
        } else {
            $pageArgs["gameData"] = [];
        }

        $lineCommision = (1 - $lineChargeRate / 100) * $TotalCommision;
        $pageArgs["TotalWinLose"] = $TotalWinLose;
        $pageArgs["TotalCommision"] = $TotalCommision;
        $pageArgs["TotalWater"] = $TotalWater;
        $pageArgs["TotalStake"] = $TotalStake;
        $pageArgs["lineCommision"] = $lineCommision;
        $pageArgs["lineChargeRate"] = $lineChargeRate;

        $_SESSION["bladeArgs"] = $pageArgs;

        $factory = View::getView();
        $crHtml = $factory->make('Agent\reports\benifitReports\GameCommission', $pageArgs)
            ->render();
        return array($crHtml, $lineCommision);
    }

    public static function settleDetail($request)
    {
        $data = getSessionValue("GameCommision", array());
        $month = getArrayValue("month", "", $request);
        $commisionHtml = getArrayValue($month, array(), $data);
        $gcHtml = getArrayValue("gc", "", $commisionHtml);
        $ccHtml = getArrayValue("cc", "", $commisionHtml);

        $factory = View::getView();
        $pageArgs = [
            "GameCommisionData" => $gcHtml,
            "ChildCommisionData" => $ccHtml,
        ];
        $settleDetail = $factory->make('Agent\reports\benifitReports\settleDetail', $pageArgs)
            ->render();
        return [true, $settleDetail];
    }

    public static function settleDetail2($request)
    {
        $data = getSessionValue("GameCommision", array());
        $month = getArrayValue("month", "", $request);
        $commisionHtml = getArrayValue($month, array(), $data);
        $caHtmlData = getArrayValue("ca", array(), $commisionHtml);

        $caHtaml1 = getArrayValue(0, "", $caHtmlData);
        $caHtaml2 = getArrayValue(1, "", $caHtmlData);

        $factory = View::getView();
        $pageArgs = [
            "GameCommisionData" => $caHtaml1,
            "ChildCommisionData" => $caHtaml2,
        ];
        $settleDetail2 = $factory->make('Agent\reports\benifitReports\settleDetail2', $pageArgs)
            ->render();
        return [true, $settleDetail2];
    }

    public static function getReportData()
    {

        $loginSession = getSessionValue("AgentSessionID", "");
        $retJson = http::agentHttpCaller("GetChildAgents", array($loginSession));
        $retData = getArrayValue(0, array(), $retJson);
        return $retData;
    }

    public static function memberlistAjax($request)
    {
        $st = $request["startdate"];
        $st = empty($st) ? time() - 60 * 24 * 60 * 30 : strtotime($st);
        $st = $st < 0 ? 0 : $st;

        $et = $request["enddate"];
        $et = empty($et) ? time() : strtotime($et);
        $et = $et < 0 ? 0 : $et;

        $loginSession = getSessionValue("AgentSessionID", "");

        $retJson = http::agentHttpCaller("GetPlayer", [$loginSession, $st, $et, 1, 999]);
        $retData = getArrayValue(0, array(), $retJson);
        $retData = getArrayValue("data", array(), $retData);
        $content = self::showMemberRepHtml($retData);
        return [true, count($retData), $content];
    }

    /**
     * 构建下线会员列表数据
     *
     * @param [type] $ret
     * @return void
     */
    private static function showMemberRepHtml($ret)
    {
        $html = "";
        $pdep = 0;
        $pwithd = 0;
        $pbet = 0;
        $pwin = 0;
        for ($x = 0; $x < count($ret); $x++) {
            $_data = $ret[$x];
            $depsit = getArrayValue("depositAmount", 0, $_data);
            $pdep += $depsit;
            $withDrawal = getArrayValue("withdrawalAmount", 0, $_data);
            $pwithd += $withDrawal;
            $bet = getArrayValue("stakeAmount", 0, $_data);
            $pbet += $bet;
            $winLoss = getArrayValue("winLoseAmount", 0, $_data);
            $pwin += $winLoss;
            $onlineTime = getArrayValue("onlineTime", 0, $_data);
            $name = getArrayValue("name", "", $_data);
            $joinTime = getArrayValue("joinTime", 0, $_data);
            $idx = $x + 1;
            if ($onlineTime == 0) {
                $onlineTag = "<td>" . $_data["account"] . "</td>";
            } else {
                if ($onlineTime < 0) {
                    $onlineTag = "<td class='green'>" . $_data["account"] . "(在线)</td>";
                } elseif ($onlineTime < 60) {
                    $onlineTag = "<td>" . $_data["account"] . "(1分钟内)</td>";
                } else {
                    $onlineTag = "<td>" . $_data["account"] . "(" . self::parseTimeTag($onlineTime) . "前)</td>";
                }
            }
            $_html = "<tr><td>" . $idx . "</td>";
            $_html .= $onlineTag;
            $_html .= "<td>" . $name . "</td>";
            $_html .= "<td>" . parseDate($joinTime, 2) . "</td>";
            $_html .= "<td>" . $depsit . "</td>";
            $_html .= "<td>" . $withDrawal . "</td>";
            $_html .= "<td>" . $bet . "</td>";
            $_html .= "<td>" . $winLoss . "</td></tr>";
            $html .= $_html;
        }
        $html .= "<tr><td colspan='4'>合计</td><td>" . $pdep . "</td><td>" . $pwithd . "</td><td>" . $pbet . "</td><td>" . $pwin . "</td></tr>";
        return $html;
    }

    public static function betHistoryAjax($request)
    {
        $st = getArrayValue("startdate", "", $request);
        $st = empty($st) ? time() - 60 * 24 * 60 * 30 : strtotime($st);
        $st = $st < 0 ? 0 : $st;

        $et = getArrayValue("enddate", "", $request);
        $et = empty($et) ? time() : strtotime($et);
        $et = $et < 0 ? 0 : $et;

        $loginSession = getSessionValue("AgentSessionID", "");
        $reqAcc = getArrayValue("account", "", $request);
        $reqPlat = getArrayValue("platform", "", $request);
        $reqChoose = getArrayValue("choose", "", $request);

        $retJson = http::agentHttpCaller("GetPlayerBetRecord", array($loginSession, $reqAcc, $reqPlat, $st, $et, 1, 999));

        $retData = getArrayValue(1, array(), $retJson);
        $retData = getArrayValue("data", array(), $retData);

        // 构建blade模板所需参数
        $ret = [];
        $toGameContent = [
            // 根据平台不同，对应不同的静态content构建方法
            // 用以生成平台对应的content解析内容
            "IBC" => "makeIBCContent",
            "NB" => "makeNBContent",
            "IG" => "makeIGContent",
        ];
        foreach ($retData as $_record) {
            $platform = $_record["platform"];
            $t = [
                "account" => $_record["account"],
                "dno" => $_record["dno"],
                "time" => parseDate($_record["recordTime"], 4),
                "winloss" => $_record["winLoseAmount"],
                "amount" => $_record["stakeAmount"],
            ];
            $t["content"] = call_user_func_array([
                "App\Controllers\AgentAPIController", $toGameContent[$platform]],
                [$_record]
            );
            array_push($ret, $t);
        }

        $factory = View::getView();
        $tableHtml = $factory->make('Agent.reports.betHistory', ["historyRecords" => $ret])
            ->render();
        return [true, $tableHtml];
    }


    /**
     * 构建NB平台数据
     *
     * @param [type] $data 数据
     *
     * @return void
     */
    public static function makeNBContent($data)
    {
        $account = $data["account"];
        $platform = $data["platform"];
        $game = $data["game"];
        $dno = $data["dno"];
        $betId = $data["betId"];
        $content = $data["content"];
        $contentStr = explode("|", $content);
        if (count($contentStr) == 0) {
            return "";
        }
        //取用NB的content数据中的值进行处理
        $gameType = $contentStr[0];
        
        // $account = getArrayValue(2, "", $contentStr);
        $matchNo = $contentStr[3];
        $matchType = $contentStr[4];
        $Odds = $contentStr[6];
        $betAmount = (float) $contentStr[6];
        $companyWinLoss = (float) $contentStr[7];
        $betTime = $contentStr[8];
        $betResult = $contentStr[9];

        $rebateStatus = getArrayValue("isRebateValid", false, $data);
        if ($betResult == "1") {
            $resultSTR = "结算完成";
            $BonusAmount = $betAmount - $companyWinLoss;
        } else {
            $resultSTR = "待结算";
            $BonusAmount = 0;
        }

        if ($rebateStatus == 1) {
            $validSTR = "有效";
            $operStr = array("red", "99", $betId, $dno, "", "设为无效");
        } else {
            $validSTR = "无效";
            $operStr = array("green", "66", $betId, $dno, "", "设为有效");
        }
        $showInfoline1 = NBConfig::NBbetTypeName[$gameType] . " 第" . $matchNo . "期";
        $showInfoline2 = $matchType . "@" . $Odds;
        $betInfos = array($showInfoline1, $showInfoline2);
        $contentStr = join("<br>", $betInfos);

        $validAmount = abs($betAmount) < abs($companyWinLoss) ? abs($betAmount) : abs($companyWinLoss);
        if ($companyWinLoss < 0) {
            $betStr = array("red", number_format($betAmount, 2));
            $winStr = array("red", number_format($companyWinLoss, 2));
            $bonusStr = array("red", number_format($BonusAmount, 2));
            $validAmountStr = array("red", number_format($validAmount, 2));
        } else {
            $betStr = array("green", number_format($betAmount, 2));
            $winStr = array("green", number_format($companyWinLoss, 2));
            $bonusStr = array("green", number_format($BonusAmount, 2));
            $validAmountStr = array("green", number_format($validAmount, 2));
        }

        // return array($contentStr, $betAmount, $companyWinLoss);
        return $contentStr;
    }

    /**
     * 构建IBC平台的订单数据
     *
     * @param [type] $data 数据
     *
     * @return void
     */
    public static function makeIBCContent($data)
    {
        /**
         * 构建内容解析，目前是支持IBC的内容
         */
        $content = json_decode(getArrayValue("content", "{}", $data), true);
        $ParlayRefNo = (int) getArrayValue("ParlayRefNo", 0, $content);
        if ($ParlayRefNo == 0) {
            /**
             * 单独注单的数据
             */
            $sportName = IBCConfig::sportsType[$content["SportType"]];

            $leagueName = $content["LeagueName"];
            $HomeIDName = $content["HomeIDName"];
            $AwayIDName = $content["AwayIDName"];
            $HDP = $content["HDP"];
            $HomeScore = $content["HomeScore"];
            $AwayScore = $content["AwayScore"];
            $BetTypeID = $content["BetType"];
            $TransactionTime = $content["TransactionTime"];
            $BetTeam = $content["BetTeam"];
            $OddsType = $content["OddsType"];
            $Odds = $content["Odds"];
            // {"TransId":103595390108,"PlayerName":"player001","TransactionTime":"2018-03-14T03:34:00.287","MatchId":24511953,"LeagueId":59647,
            //"LeagueName":"Dota 2 - \u4e16\u754c\u7535\u5b50\u7ade\u6280\u8fd0\u52a8\u4f1a","SportType":43,"AwayId":440869,"AwayIDName":"Team Serbia",
            //"HomeId":461483,"HomeIDName":"Volta7","MatchDatetime":"2018-03-14T04:59:59","BetType":20,"ParlayRefNo":0,"BetTeam":"h","HDP":0,"AwayHDP":0,
            //"HomeHDP":0,"Odds":7.25,"OddsType":3,"AwayScore":null,"HomeScore":null,"IsLive":"0","IsLucky":"False","Bet_Tag":"","LastBallNo":"",
            //"TicketStatus":"LOSE","Stake":10,"WinLoseAmount":-10,"AfterAmount":2.5,"WinLostDateTime":"2018-03-14T00:00:00","currency":"RMB",
            //"VersionKey":25035491}
            $BtConfig = getArrayValue($BetTypeID, "", IBCConfig::betTypeNames); // 会出现未配置情况，最好加入取值保护
            if (!$BtConfig) {
                $BetTypeStr = "todo:need more configs";
            } else {
                $BetTypeStr = $BtConfig["name"];
            }

            $BetArgus = getArrayValue("argus", array(), $BtConfig);
            if (!empty($BetArgus) && !empty($BetTeam) && !empty($OddsType)) {
                $btTeamStr = $BetArgus[$BetTeam];
                $otNameStr = IBCConfig::oddsType[$OddsType];
                $btOddStr = $btTeamStr . "@" . $otNameStr . " - (" . $Odds . ")";
            } else {
                $btOddStr = "todo: odds - " . $BetTeam . " - " . $Odds;
            }

            $showLeagueInfo = $sportName . " - " . $leagueName;
            $showTeamInfo = $HomeIDName . " vs " . $AwayIDName . "(" . $HDP . ")";
            $showScoreInfo = "(" . $AwayScore . " : " . $HomeScore . ")";

            $betInfos = [
                $showLeagueInfo,
                $showTeamInfo,
                $showScoreInfo,
                $BetTypeStr,
                $btOddStr,
                str_replace("T", " ", $TransactionTime),
            ];
            $contentStr = join("<br>", $betInfos);
        } else {
            /**
             * 串单的数据
             */
            $parleyData = getArrayValue("ParlayData", array(), $content);
            $parleyShowInfo = array();
            foreach ($parleyData as $_parley) {
                $sportType = $_parley["Parlay_SportType"];
                $sportName = IBCConfig::sportsType[$sportType];

                $leagueName = $_parley["LeagueName"];
                $HomeIDName = $_parley["Parlay_HomeIDName"];
                $AwayIDName = $_parley["Parlay_AwayIDName"];
                $HDP = $con_parleytent["Parlay_HDP"];
                $HomeScore = $con_parleytent["Parlay_HomeScore"];
                $AwayScore = $con_parleytent["Parlay_AwayScore"];
                $BetTypeID = $con_parleytent["Parlay_BetType"];
                $TransactionTime = $con_parleytent["Parlay_MatchDatetime"];

                $BetTeam = $con_parleytent["Parlay_BetTeam"];
                $Odds = $con_parleytent["Parlay_Odds"];
                $BtConfig = IBCConfig::betTypeNames[$BetTypeID];

                if (!empty($BtConfig)) {
                    $BetTypeStr = $BtConfig["name"];
                } else {
                    $BetTypeStr = "todo:need more configs";
                }

                $BetArgus = getArrayValue("argus", array(), $BtConfig);
                if (!empty($BetArgus) && !empty($BetTeam)) {
                    $btTeamStr = getArrayValue($BetTeam, "", $BetArgus);
                    $btOddStr = "@" . $btTeamStr . " - (" . $Odds . ")";
                } else {

                    $btOddStr = "todo: odds - " . $BetTeam . " - " . $Odds;
                }
                $showLeagueInfo = $sportName . " - " . $leagueName;
                $showTeamInfo = $HomeIDName . " vs " . $AwayIDName . "(" . $HDP . ")";
                $showScoreInfo = "(" . $AwayScore . " : " . $HomeScore . ")";

                $betInfos = [
                    $showLeagueInfo,
                    $showTeamInfo,
                    $showScoreInfo . $BetTypeStr . $btOddStr,
                    str_replace("T", " ", $TransactionTime),
                ];
                $_parleyInfo = join("<br>", $betInfos);
                array_push($parleyShowInfo, $_parleyInfo);
            }
            $contentStr = join("<br><br>", $parleyShowInfo);
        }
        return $contentStr;
    }

    /**
     * 每日报表的Ajax数据处理
     *
     * @param [type] $request
     *
     * @return void
     */
    public static function dailyreportAjax($request)
    {
        $st = getArrayValue("startdate", "", $request);
        $st = empty($st) ? time() - 60 * 24 * 60 * 30 : strtotime($st);

        $et = getArrayValue("enddate", "", $request);
        $et = empty($et) ? time() : strtotime($et);

        $loginSession = getSessionValue("AgentSessionID", "");
        $retJson = http::agentHttpCaller("GetDayStatement", array($loginSession, $st, $et));
        $retData = getArrayValue("data", array(), $retJson);
        unset($retJson["data"]);
        $retData = getArrayValue(0, array(), $retData);

        $gp_arr = array();
        $t_arr = array();
        foreach ($retData as $_ret) {
            $game = getArrayValue("game", "", $_ret);
            if (!in_array($game, $gp_arr)) {
                array_push($gp_arr, $game);
            }
            $_date = (string) getArrayValue("day", "", $_ret);
            if (!array_key_exists($_date, $t_arr)) {
                $t_arr[$_date] = array();
            }

            if (!array_key_exists($game, $t_arr[$_date])) {
                $t_arr[$_date][$game] = array();
            }
            array_push($t_arr[$_date][$game], $_ret);
        }
        $_title = "<tr><th width=\"120px\">日期</th><th>合计<br/>投注/输赢</th>";
        foreach ($gp_arr as $_gp) {
            $_title .= "<th width=\"120px\">" . $_gp . "<br/>投注/输赢</th>";
        }
        $_title .= "</tr>";
        $html = "";

        ksort($t_arr);
        foreach ($t_arr as $_dt => $gd) {

            $tBet = 0;
            $tWin = 0;
            $_tds = "";
            foreach ($gd as $_gp => $_td) {
                $_td_data = getArrayValue(0, array(), $_td);
                $bet = getArrayValue("stakeAmount", 0, $_td_data);
                $win = getArrayValue("winLoseAmount", 0, $_td_data);
                $tBet += $bet;
                $tWin += $win;
                $_tds .= "<td>" . $bet . "/" . $win . "</td>";
            }
            $_html = "<tr><td>" . $_dt . "</td>";
            $_html .= "<td>" . $tBet . "/" . $tWin . "</td>";
            $_html .= $_tds . "</tr>";

            $html .= $_html;
        }

        return [true, $html, $_title];
    }
}
