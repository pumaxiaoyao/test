<?php
/**
 * 玩家的controllers入口，只能通过路由脚本调用
 */
registerDataHelper(array("protoHelper", "dataHelper"));
registerViewHelper(array("GmViewHelper", "player/PlayerViewHelper", "player/PlayerDetailViewHelper"));
registerCtrlHelper(array("player/playertrait"));

/**
 * 玩家模块的玩家类，提供给URI路由调用后的方法访问
 * 
 * @category Application/controllers/player
 * @package  Player
 * @author   alien <alien@alien.com>
 * @license  http://license.alien.com/license, alien
 * @link     null
 */
class Player
{
    use PlayerTrait;//申明API引用
    
    /**
     * URI：online
     * 请求在线用户的Html页面
     *
     * @return null
     */
    static function online()
    {  
        showOnline(__CLASS__);
    }
    
    /**
     * URI：allRoles（Page请求是list，路由方法中强转了方法名）
     * 请求所有用户的Html页面
     *
     * @return null
     */
    static function allRoles()
    {
        showList(__CLASS__);
    }

    /**
     * URI：regDaily
     * 请求当日注册用户的Html页面
     *
     * @return void
     */
    static function regDaily()
    {
        showRegDaily(__CLASS__);
    }

    /**
     * URI：fundflow
     * 请求用户资金流水的Html页面
     *
     * @return void
     */
    static function fundFlow()
    {
        showFundFlow(__CLASS__);
    }

    /**
     * URI：playerDetail
     * 请求用户资料修改界面的Html页面
     *
     * @param array $request URI参数
     * 
     * @return void
     */  
    static function playerDetail($request)
    {
        $RequestMemberName = getArrayValue("id", "", $request);
        $errorRet = $GLOBALS["errorRet"];
        if (empty($RequestMemberName)) {
            return $errorRet;
        }
        $_SESSION["RequestMemberName"] = $RequestMemberName;
        $retJson = gmServerCaller("GetPlayerBaseInfo", array($RequestMemberName));
        $playerdata = getArrayValue(0, array(), $retJson);
        $Html = readHtml("playerDetail/player_detail");
        $layerLevel = getArrayValue("groupName", 0, $playerdata);
        $statusCode = getArrayValue("status", 0, $playerdata);
        $timeTag = getArrayValue("joinTime", "", $playerdata);
        $replaceArray = array(
            "ACCOUNT"=>$RequestMemberName,
            "name"=>getArrayValue("name", "", $playerdata),
            "layer"=>getArrayValue($layerLevel, "", $GLOBALS["LayerNames"]),
            "status"=>getArrayValue($statusCode, "", $GLOBALS["roleStatusCode"]),
            "agent"=>getArrayValue("agentName", "", $playerdata),
            "qq"=>getArrayValue("qq", "", $playerdata),
            "cellPhoneNo"=>getArrayValue("cellPhoneNo", "", $playerdata),
            "birthDate"=>getArrayValue("birthDate", "", $playerdata),
            "email"=>getArrayValue("email", "", $playerdata),
            "joinTime"=>parseDate($timeTag),
            "joinIp"=>getArrayValue("joinIp", "", $playerdata),
            "lastLoginTime"=>parseDate(getArrayValue("lastLoginTime", "", $playerdata)),
            "mainBalance"=>getArrayValue("mainBalance", "", $playerdata),
        );
        foreach ($replaceArray as $_key => $_vals) {
            $Html = str_replace("%".$_key. "%", $_vals, $Html);
        }
        

        $page = array(
            makeHeaderPage(""),
            $Html,
            makeFooterPage("player_detail_footer"),
        );
        output(join("", $page));
    }

    /**
     * URI：playerDetailBox
     * 请求用户详情界面的Html页面
     *
     * @param array $request URI参数
     * 
     * @return void
     */  
    static function playerDetailBox($request)
    {
        $RequestMemberName = getArrayValue("id", "", $request);
        $errorRet = $GLOBALS["errorRet"];
        if (empty($RequestMemberName)) {
            return $errorRet;
        }
        $_SESSION["RequestMemberName"] = $RequestMemberName;

        $retJson = gmServerCaller("GetPlayerBaseInfo", array($RequestMemberName));
        $playerData = getArrayValue(0, array(), $retJson);
        $RequestStart = time() - 30 * 24 * 60 * 60;
        $RequestEnd = time();
        // print_r($retJson);
        $playerData["account"] = $RequestMemberName;
        $playerDetailBoxHtml = readHtml("playerDetail/player_box_header");
        $DetailTabDatas = array(
            MakeDT_baseInfo(readHtml("playerDetail/player_box_tab1"), $playerData),
            readHtml("playerDetail/player_box_tab2"),
            readHtml("playerDetail/player_box_tab3"),
            readHtml("playerDetail/player_box_tab4"),
            readHtml("playerDetail/player_box_tab5"),
            MakeDT_sameDataInfo(readHtml("playerDetail/player_box_tab6"), $playerData),
            readHtml("playerDetail/player_box_tab7"),
            readHtml("playerDetail/player_box_tab8"),
        );
        $DetailTabHtml = join("", $DetailTabDatas);
        $DetailTabHtml = str_replace("%STARTTIME%", parseDate($RequestStart), $DetailTabHtml);
        $DetailTabHtml = str_replace("%ENDTIME%", parseDate($RequestEnd), $DetailTabHtml);
        $DetailTabHtml = str_replace("%ACCOUNT%", $RequestMemberName, $DetailTabHtml);

        $page = str_replace("%TABCONTENTS%", $DetailTabHtml, $playerDetailBoxHtml);
        output($page);
    }

}
?>