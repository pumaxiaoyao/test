<?php
/**
 * 协议处理
 */



function getBaseUrl()
{
    refreshServerConfig();
    $ServerHost = getArrayValue("ServerHost", "localhost", $GLOBALS);
    $ServerPort = getArrayValue("ServerPort", "7879", $GLOBALS);
    $ShowDebug  = getArrayValue("ShowDebug", "true", $GLOBALS);
    return array(join("", array("http://", $ServerHost, ":",$ServerPort,"/GatePlayer")), $ShowDebug);
}


function getAgentBaseUrl()
{
    refreshServerConfig();
    $ServerHost = getArrayValue("ServerHost", "localhost", $GLOBALS);
    $ServerPort = getArrayValue("ServerPort", "7879", $GLOBALS);
    $ShowDebug  = getArrayValue("ShowDebug", "true", $GLOBALS);
    return array(join("", array("http://", $ServerHost, ":",$ServerPort,"/GateAgent")), $ShowDebug);
}

/**
 * 玩家入口调用
 *
 * @param [type] $_caller 调用命令
 * @param [type] $_argus  调用参数
 * 
 * @return void
 */
function GmServerCaller($_caller, $_argus)
{
    $baseData = getBaseUrl();
    return commonHttpCaller($_caller, $_argus, $baseData[0], $baseData[1]);
}

/**
 * 代理入口调用
 *
 * @param [type] $_caller 调用命令
 * @param [type] $_argus  调用参数
 * 
 * @return void
 */
function AgentServerCaller($_caller, $_argus)
{
    $baseData = getAgentBaseUrl();
    return commonHttpCaller($_caller, $_argus, $baseData[0], $baseData[1]);
}

/**
 * 重新构建的通用Http访问接口
 *
 * @param [type] $_caller 命令
 * @param [type] $_argus  参数
 * @param [type] $_url    后台URL
 * @param [type] $_debug  是否开启调试
 * 
 * @return void
 */
function commonHttpCaller($_caller, $_argus, $_url, $_debug)
{
    //初始化返回数据结构
    $retstruc = $GLOBALS["retstruc"];
    //后台特殊返回集合，即不返回true、false结构的命令
    $specificMethod = array(
        "GetSessionState", "GetBalanceAmount", "GetChildAgents", "GetSettleStatement", "GetPlayer", "GetDayStatement",
        "GetJointInfo"

    );
    //构建请求的参数体
    $_request = array(
        "call"=>$_caller,
        "params"=>json_encode($_argus)
    );
    //对后台发送实际请求
    $retJson = json_decode(CurlPost($_url, $_request), true);
    //增加debug返回信息
    if ($_debug) {
        $retstruc["DEBUG"] = array(
            "URL"=>$_url."?". http_build_query($_request),
            "request"=>http_build_query($_request),
            "return"=>$retJson
        );
    }

    if (count($retJson) === 0) {
        //后台无返回
        $retstruc["code"] = 404;
        $retstruc["Message"] = "error data get from base server.";
    } else {
        
        if (in_array($_caller, $specificMethod)){
            //后台返回的第一个参数不是请求是否成功的bool值情况
            //此情况下，暂不处理异常返回
            $retstruc["code"] = 200;
            $retstruc["data"] = $retJson;
        } else {
            if ($retJson[0] != 1) {
                //后台返回错误
                $retstruc["code"] = 500;
                $errorMsg = getArrayValue(1, "no error msg from base server.", $retJson);
                if ($errorMsg == "sessionError" || $errorMsg == "sessionInvalid") {
                    $retstruc["code"] = 999;
                    AgentLoginReset(false);
                }
                $retstruc["Message"] = $errorMsg;
            } else {
                //后台返回正确
                $retstruc["code"] = 200;
                $retstruc["data"] = array_slice($retJson, 1);
            }
        }
    }
    return $retstruc;
}


/**
 * 预处理返回的数据
 *
 * @param [type] $retJson 数据
 * 
 * @return void
 */
function parseRetData($retJson, $_caller, $_argus)
{
    $retstruc = $GLOBALS["retstruc"];
    $specificMethod = array(
        "GetSessionState"
    );
    if (count($retJson) === 0) {
        $retstruc["code"] = 404;
        $retstruc["Message"] = "error data get from base server.";
    } else {
        if (in_array($_caller, $specificMethod)){
            //后台返回的第一个参数不是请求是否成功的bool值情况
            $retstruc["code"] = 200;
            $retstruc["data"] = $retJson;
        } else {
            if ($retJson[0] != 1) {
                $retstruc["code"] = 500;
                $errorMsg = getArrayValue(1, "no error msg from base server.", $retJson);
                if ($errorMsg == "sessionError") {
                    $retstruc["code"] = 999;
                    LoginReset(false);
                }
                if ($errorMsg == "sessionInvalid") {
                    $retstruc["code"] = 999;
                    // 非法session，需要单独检查非法原因，看是否是被踢下线
                    // 代码臃肿，暂时先屏蔽
                    // $retJson1 = GmServerCaller("GetSessionState", array(getArrayValue(0, "", $_argus)));
                    // if(getArrayValue("code", "", $retJson1) == 200){
                    //     $retData1 = getArrayValue(0, "", $retJson1["data"]);
                    //     $inValidMsg = getArrayValue("code", "", $retData1);
                    //     if ($inValidMsg == "kickByGM"){
                    //         $time1 = parseDate(getArrayValue('time', '', $retData1));
                    //         $inValidMsg = "您因违规，于[".$time1."]被客服强制下线";
                    //     }
                    //     $retstruc["Message"] = $inValidMsg;
                    // }else{
                    //     $retstruc["Message"] = $errorMsg;
                    // }
                    // $retstruc["retJson1"] = $retJson1;
                    LoginReset();
                } else {
                    $retstruc["Message"] = $errorMsg;
                }
                
            }else{
                $retstruc["code"] = 200;
                $retstruc["data"] = array_slice($retJson, 1);
            }
        }
    }
    return $retstruc;
}

function CurlPost($url, $data, $_cookie = ""){
    /**
     * 利用curl构建的http-post工具
     */
    $ch = curl_init();
    $_header = array("content-type: application/json;charset=UTF-8;", 'Connection: Keep-Alive', 'Keep-Alive: 300', "Upgrade-Insecure-Requests: 1");
    curl_setopt($ch, CURLOPT_URL, $url."?".http_build_query($data));//
    // curl_setopt($ch, CURLOPT_URL, $url . urlencode($data));
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $_header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    if (curl_errno($ch)) {                
        return 'Errno'.curl_error($ch);           
    }else{
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }
}

function ProcessSportsLoginWithoutAccount(){
    return "http://mkt.ib.abet.life/vender.aspx?lang=cs";
}

function ProcessSportsLogin($token){
    return "http://mkt.ib.abet.life/Deposit_ProcessLogin.aspx?lang=cs&g=".$token;
}


?>