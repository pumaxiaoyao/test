<?php

/**
 * 读取数据服务器IP配置
 *
 * @return void
 */
function refreshServerConfig()
{
    $config = json_decode(file_get_contents("../config.json"), true);
    $GMConfig = getArrayValue("GM", array(), $config);
    $ServerHost = getArrayValue("ServerHost", "localhost", $GMConfig);
    $ServerPort = getArrayValue("ServerPort", "7879", $GMConfig);
    $ShowDebug = getArrayValue("ShowDebug", "true", $GMConfig);

    $GLOBALS["ServerHost"] = $ServerHost;
    $GLOBALS["ServerPort"] = $ServerPort;
    $GLOBALS["ShowDebug"] = $ShowDebug;
}

/**
 * 获取基础后台服务器地址
 *
 * @return void
 */
function getBaseUrl()
{
    refreshServerConfig();
    $ServerHost = getArrayValue("ServerHost", "localhost", $GLOBALS);
    $ServerPort = getArrayValue("ServerPort", "7879", $GLOBALS);
    $ShowDebug  = getArrayValue("ShowDebug", "true", $GLOBALS);
    return array(join("", array("http://", $ServerHost, ":",$ServerPort,"/Gm")), $ShowDebug);
}

/**
 * 获取基础后台代理服务器地址
 *
 * @return void
 */
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
function gmServerCaller($_caller, $_argus)
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
function agentServerCaller($_caller, $_argus)
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
    $_request = array("call"=>$_caller,"params"=>json_encode($_argus));
    $raw_ret = curlPost($_url, $_request);
    // print_r($raw_ret);
    
    $retJson = json_decode($raw_ret, true);
    $debugInfo = array(
        "URL"=>$_url. "?" . http_build_query($_request),
        "request"=>$_request,
        "return"=>$retJson,
        "length"=>mb_strlen($raw_ret, 'UTF8')
    );
    // if (!$retJson) {
    //     $ret = json_last_error();
    //     print($ret);
    //     print(json_last_error_msg());
    // }
    
    $_SESSION["retJson"] = $debugInfo;
    return $retJson;
}

/**
 * CurlHttpPost 方法
 *
 * @param [type] $url     URL路径
 * @param [type] $data    参数
 * @param string $_cookie cookie
 * 
 * @return void
 */
function curlPost($url, $data, $_cookie = "")
{
    /**
     * 利用curl构建的http-post工具
     */
    $ch = curl_init();
    $_header = array("content-type: application/json;charset=UTF-8");
    curl_setopt($ch, CURLOPT_URL, $url."?".http_build_query($data));
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $_header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    // curl_setopt($ch, CURLOPT_POSTFIELDS,  $data);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    if (curl_errno($ch)) {                
        return 'Errno'.curl_error($ch);           
    } else {
        $ret = curl_exec($ch);
        curl_close($ch);
        return $ret;
    }
}

/**
 * CurlHttps request
 *
 * @param string $url 路径
 * 
 * @return void
 */
function curlHttpsGet($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
    if (curl_errno($ch)) {                
        return 'Errno'.curl_error($ch);           
    } else {
        $ret = curl_exec($ch);
        $retSize = strlen($ret);
        $info = curl_getinfo($ch);
        curl_close($ch);
        return $ret;
    }
}


function Base_GetVpKey(){
    /**
     * PHP接口，获取加密的rsa密钥
    */
    return array('exponent'=>'AQAB',
    'modulus'=>'AI7Lozg8gHiZJ+FWfLdzyliAPLTAlyfU/HVac/3SSDGANu2ttaHnnsJeT6BHL60PEO5I1A3GqRIWs8fTFjavFiS0/vv7/uAoInM2fUEDIyuTTuMyANDDWDiYjvUfe2qncIt9r8VsXtptOUAV8r5DVgw1COGYCOPKoYHkHL3ZsTsb');  
}

/**
 * 获取公共消息的方法
 *
 * @return void
 */
function Base_getMsgStatus()
{
    /**
     * 获得公共消息
    */
    $ret = array(
        "code"=>0,
        "data"=>array(
            array(
                array(
                    "id"=>268,
                    "title"=>"电子竞技平台esports入驻kzing系统",
                    "content"=>"尊敬的kzing客户：\r\n电子竞技已成为当今社会主流的娱乐项目，esports是一家专门分析开发电子竞技娱乐的博彩公司，严谨的赔率设定，专业的比赛数据分析以及游戏比赛的直播，吸引了众多电子竞技爱好者的关注，在观看比赛的同时小赌怡情。现在kzing有幸独家接入esports平台，有兴趣的客户可以直接联系蒋先生安排接入，谢谢！",
                    "type"=>99,
                    "start"=>1506441600,
                    "end"=>1514735999
                ),
                array(
                    "id"=>262,
                    "title"=>"全新多盘口体育平台stag8入驻kzing",
                    "content"=>"尊敬的kzing客户：\r\n2018年世界杯即将到来，为了更好地满足玩家的需求，kzing接入了全新的体育平台stag8，能够在一个平台拥有所有平台的最佳赔率，只需一个钱包就能在所有的平台下注，让玩家可以全天候的在各种电子设备上都能轻松的以最具有透明性的报价进行交易。\r\n如有需要，请咨询蒋先生接入，谢谢！",
                    "type"=>99,
                    "start"=>1505440800,
                    "end"=>1514735999
                ),
                array(
                    "id"=>"9283948292833",
                    "flag"=>3,
                    "name"=>"欧博真人",
                    "start"=>"2017-10-11 08:00:00",
                    "end"=>"2017-10-11 12:00:00",
                    "content"=>"尊敬的用户：欧博平台进行維護，届时平台暂时关闭，请在维护完成之后再进入游戏，不便之处，敬请谅解！"
                ),
            ),
        ),
    );
    return $ret;
}

/**
 * 登录协议
 *
 * @return void
 */
function Base_login()
{
    return array("c"=>0,"d"=>null,"m"=>"ok");
}

function Base_GetTaskList(){
    return array(
        "rega"=>array(),
        "wtda"=>array(),
        "wtdu"=>array(),
        "dptu"=>array(),
        "dptf"=>array(),
        "actv"=>array()
    );
}

function Base_GetBet(){
    return file_get_contents("./application/utilities/testdata/chartdata/bet.json");
}

function Base_GetBetDaily(){
    return file_get_contents("./application/utilities/testdata/chartdata/betdaily.json");
}

function Base_GetCost(){
    return file_get_contents("./application/utilities/testdata/chartdata/cost.json");
}

function Base_GetDw(){
    return file_get_contents("./application/utilities/testdata/chartdata/dw.json");
}

function Base_GetInfo(){
    $ret = file_get_contents("./application/utilities/testdata/chartdata/getInfo.json");
    echo $ret;
    //return json_decode(json_encode($ret), true);
}

function Base_GetNewPlayer(){
    return file_get_contents("./application/utilities/testdata/chartdata/newplayer.json");
}

function Base_GetWlTotal(){
    return file_get_contents("./application/utilities/testdata/chartdata/wltotal.json");
}

function Base_playerMsgList(){
    return file_get_contents("./application/utilities/testdata/playerMessageList.json");
}

function Base_agentMsgList(){
    return file_get_contents("./application/utilities/testdata/playerMessageList.json");
}
?>