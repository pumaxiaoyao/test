<?php  
/**
 * Settings的API接口，用于提供给Js_Ajax请求的方法定义
 * 
 * PHP version 7.10
 * 
 * @category Application/controllers/settings
 * @package  Settings
 * @author   alien <alien@alien.com>
 * @license  http://license.alien.com/license, alien
 * @link     null
 */


registerDataHelper(array("protoHelper", "dataHelper"));
registerViewHelper(array("GmViewHelper", "setting/SettingViewHelper"));
registerCtrlHelper(array("settings/settingtrait"));

/**
 * 设置模块的入口类，提供给URI路由调用后的方法访问
 * 
 * @category Application/controllers/settting
 * @package  Setting
 * @author   alien <alien@alien.com>
 * @license  http://license.alien.com/license, alien
 * @link     null
 */
class Settings
{
    use SettingsTrait;
    /**
     * 玩家组设置界面
     *
     * @return void
     */
    static function playerLevel()
    {  
        showplayerLevel();
    }

    /**
     * 玩家组属性设置界面
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function playerLevelAttribute($request)
    {
        $reqGroupID = (int)getArrayValue("groupid", "0", $request);
        $reqGroupName = getArrayValue("groupname", "", $request);
        if ($reqGroupID === 0) {
            $attr = array();
        } else {
            $LayerSetting = getSessionValue("layerSetting", array());
            $attr = getArrayValue($reqGroupID, array(), $LayerSetting);
        }
        $attrHtml = readHtml("settings/playerLevelAttr");

        $_attrHtml = makePLAttrHtml($reqGroupID, $attr);
        $maxGpID = count($attr);
        
        
        $attrHtml = str_replace("%MAXLAYER%", $maxGpID, $attrHtml);
        $attrHtml = str_replace("%GROUPID%", $reqGroupID, $attrHtml);
        $attrHtml = str_replace("%GROUPNAME%", "玩家组 - " . $reqGroupName, $attrHtml);
        $attrHtml = str_replace("%groupdata%", $_attrHtml, $attrHtml);
        $page = array(
            makeHeaderPage(""),
            $attrHtml,
            makeFooterPage(""),
        );

        output(join("", $page));
    }
    /**
     * 获取玩家组的玩家层级属性对应的返水数据
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function getLayerRebateSetting($request)
    {
        $defaultAttr = array(
            "NB"=>array(
                "rebateStepRate"=>"",
                "rebateRate"=>"",
            ),
            "IBC"=>array(
                "rebateStepRate"=>"",
                "rebateRate"=>"",
            )
        );
        $requestLayerID = getArrayValue("groupid", "0", $request);
        $requestGPName = getArrayValue("groupname", "", $request);
        if ($requestLayerID === "0") {
            $attr = $defaultAttr;
        } else {
            $retJson = gmServerCaller("GetPlayerLayerRebate", array($requestLayerID));
            $attr = getArrayValue(0, array(), $retJson);
            if (count($attr) == 0) {
                $gps = getArrayValue(1, array(), $retJson);
                foreach ($gps as $_gp) {
                    $attr[$_gp] = array("rebateStepRate"=>"","rebateRate"=>"",);
                }
            }
        }

        $allHtml = "";
        $x = 1;
        foreach ($attr as $GP=>$_attr) {
            $rebateStepRate = getArrayValue("rebateStepRate", "", $_attr);
            $rebateRate = getArrayValue("rebateRate", "", $_attr);
            $gameName = getArrayValue($GP, "", $GLOBALS["GP_Names"]);
            if (!empty($rebateStepRate)) {
                $rebateStr = makeFloatStr(json_decode($rebateStepRate, true));
            } else {
                $rebateStr = "";
            }
            
            $html = '<tr gpid="' . $GP . '" layerid="'. $requestLayerID .'">';
            $html .= '<td>'.$x.'</td>';
            $html .= '<td gpname=gpname>'. $gameName .'</td>';
            $html .= '<td><input name="rrate" onkeyup="setRateVal(this, 100)" class="form-control" type="text" value="'.$rebateRate.'"></td>';
            $html .= '<td name="stepped">'. $rebateStr.'</td>';
            $html .= '<td><a href="#waterLeverModal" onclick="setuplevertr(\''. $GP.'\', \''.$requestGPName.'\', \''.$gameName.'\');" data-toggle="modal" class="btn btn-xs blue">返水设置</a></td></tr>';
            $allHtml .= $html;
            $x++;
        }

        $ret = array("html"=>$allHtml, "name"=>$requestGPName);
        return output($ret, "json");
    }

    /**
     * 展示代理层级修改界面
     *
     * @return void
     */
    static function agentLevel()
    {
        showagentLevel();   
    }

    /**
     * 获取抽佣抽水界面
     *
     * @param [type] $request URI参数
     * 
     * @return void
     */
    static function getbrokerage($request)
    {
        $layerId = getArrayValue("layerid", "", $request);
        $html = "";
        $BrokerageSetting = getSessionValue("BrokerageSetting", array());
        $bsData = getArrayValue($layerId, array(), $BrokerageSetting);
        $gameData = getArrayValue("game", array(), $bsData);
        if (count($gameData) == 0) {
            $gameData = array("sport"=>array(), "pk"=>array(), "xjssc"=>array());
        }
        $comFloatData = getArrayValue("pumpingCommisionFloatRate", array(), $bsData);
        $ret = array(
            "data"=>array(),
            "commisionFloat"=>$comFloatData
        );
        if (count($gameData) > 0) {
            // {"game":{"sport":{"pumpingWatarFixedRate":0.3,"pumpingWatarRateType":1,"pumpingCommisionRate":1,"pumpingCommisionFixedRate":0.5},"pk":{"pumpingCommisionRate":2,"pumpingWatarFloatRate":[{"rate":0.5,"amount":100000},{"rate":0.2,"amount":10000},{"rate":0.1,"amount":1000}]}},"pumpingCommisionFloatRate":[{"rate":0.5,"amount":100000},{"rate":0.2,"amount":10000},{"rate":0.1,"amount":1000}]}
            $idx = 0;
            foreach ($gameData as $game=>$_data) {
                $idx ++;
                $ret["data"][$game] = array("html"=>addBrokerageTdHtml($idx, $game), "data"=>$_data);
            }
        }
        return output($ret, "json");
    }

    /**
     * 展示玩家平台列表
     *
     * @return void
     */
    function gplist()
    {
        showGPList();
    }

    /**
     * 展示客服部门
     *
     * @return void
     */
    function csDept()
    {
        showcsDept(); 
    }

    /**
     * 展示客服账号
     *
     * @return void
     */
    function csAcct()
    {
        showcsAcct(); 
    }

    /**
     * WS
     *
     * @return void
     */
    function ws()
    {
        showWS();     
    }

    /**
     * 获取配置的测试数据
     *
     * @return void
     */
    function getSysConfig()
    {
        $ret = array(
            array("cate"=>"1500","itemkey"=>"activityimgsize","itemval"=>"1200x150"),
            array("cate"=>"1202","itemkey"=>"agentallowlogin","itemval"=>"ON"),
            array("cate"=>"1203","itemkey"=>"agentallowreg","itemval"=>"ON"),
            array("cate"=>"1202","itemkey"=>"agenterrloginlocked","itemval"=>"5"),
            array("cate"=>"1203","itemkey"=>"agentforbiddennames","itemval"=>"admin"),
            array("cate"=>"1202","itemkey"=>"agentloginclosedreason","itemval"=>"\u767b\u5f55\u7cfb\u7edf\u5347\u7ea7\u4e2d\uff0c\u5982\u6709\u7591\u95ee\uff0c\u8bf7\u8054\u7cfb\u5ba2\u670d\uff01"),
            array("cate"=>"1203","itemkey"=>"agentregclosedreason","itemval"=>"\u6ce8\u518c\u7cfb\u7edf\u5347\u7ea7\u4e2d\uff0c\u5982\u6709\u7591\u95ee\uff0c\u8bf7\u8054\u7cfb\u5ba2\u670d\uff01"), 
            array("cate"=>"2200","itemkey"=>"agentreqemail","itemval"=>"ON"),
            array("cate"=>"2200","itemkey"=>"agentreqphone","itemval"=>"ON"),
            array("cate"=>"2200","itemkey"=>"agentreqqq","itemval"=>"ON"),
            array("cate"=>"1301","itemkey"=>"agentwithdrawdaylimit","itemval"=>"5"),
            array("cate"=>"1301","itemkey"=>"agentwithdrawdaymax","itemval"=>"200000.00"),
            array("cate"=>"1301","itemkey"=>"agentwithdrawmax","itemval"=>"100000.00"),
            array("cate"=>"1301","itemkey"=>"agentwithdrawmin","itemval"=>"100.00"),
            array("cate"=>"1600","itemkey"=>"allow","itemval"=>"ON"),
            array("cate"=>"1300","itemkey"=>"allowdeposit","itemval"=>"ON"),
            array("cate"=>"1300","itemkey"=>"allowdepositofatm","itemval"=>"ON"),
            array("cate"=>"1300","itemkey"=>"allowdepositofebank","itemval"=>"ON"),
            array("cate"=>"1300","itemkey"=>"allowdepositofopay","itemval"=>"ON"),
            array("cate"=>"1200","itemkey"=>"allowlogin","itemval"=>"ON"),
            array("cate"=>"1300","itemkey"=>"allowprocesscount","itemval"=>"100"),
            array("cate"=>"1201","itemkey"=>"allowreg","itemval"=>"ON"),
            array("cate"=>"1400","itemkey"=>"allowupload","itemval"=>"ON"),
            array("cate"=>"1301","itemkey"=>"allowwithdraw","itemval"=>"ON"),
            array("cate"=>"2200","itemkey"=>"checkrealname","itemval"=>"OFF"),
            array("cate"=>"1100","itemkey"=>"csallowlogin","itemval"=>"ON"),
            array("cate"=>"1401","itemkey"=>"csallowupload","itemval"=>"ON"),
            array("cate"=>"1100","itemkey"=>"cserrloginlocked","itemval"=>"5"),
            array("cate"=>"1100","itemkey"=>"csloginclosedreason","itemval"=>"\u767b\u5f55\u7cfb\u7edf\u5347\u7ea7\u4e2d\uff0c\u5982\u6709\u7591\u95ee\uff0c\u8bf7\u8054\u7cfb\u5ba2\u670d\uff01"),
            array("cate"=>"1300","itemkey"=>"depositautoreceive","itemval"=>"ON"), array("cate"=>"1300","itemkey"=>"depositofatmdaylimit","itemval"=>"100"), array("cate"=>"1300","itemkey"=>"depositofatmmax","itemval"=>"1000000.00"), array("cate"=>"1300","itemkey"=>"depositofatmmin","itemval"=>"100.00"), array("cate"=>"1300","itemkey"=>"depositofebankdaylimit","itemval"=>"100"), array("cate"=>"1300","itemkey"=>"depositofebankmax","itemval"=>"1000000.00"), array("cate"=>"1300","itemkey"=>"depositofebankmin","itemval"=>"100.00"), array("cate"=>"1300","itemkey"=>"depositofopaydaylimit","itemval"=>"100"), array("cate"=>"1300","itemkey"=>"depositofopaymax","itemval"=>"1000000.00"), array("cate"=>"1300","itemkey"=>"depositofopaymin","itemval"=>"100"), array("cate"=>"1200","itemkey"=>"errloginlocked","itemval"=>"5"), array("cate"=>"1201","itemkey"=>"forbiddennames","itemval"=>"admin"), array("cate"=>"1600","itemkey"=>"from","itemval"=>""), array("cate"=>"1600","itemkey"=>"host","itemval"=>""), array("cate"=>"1200","itemkey"=>"loginclosedreason","itemval"=>"\u767b\u5f55\u7cfb\u7edf\u5347\u7ea7\u4e2d\uff0c\u5982\u6709\u7591\u95ee\uff0c\u8bf7\u8054\u7cfb\u5ba2\u670d\uff01."), array("cate"=>"2100","itemkey"=>"noticeaudio","itemval"=>"\/incloud\/newtask.wav"), array("cate"=>"1600","itemkey"=>"password","itemval"=>""), array("cate"=>"1600","itemkey"=>"port","itemval"=>""), array("cate"=>"2200","itemkey"=>"regbirthday","itemval"=>"OFF"), array("cate"=>"1201","itemkey"=>"regclosedreason","itemval"=>"\u6ce8\u518c\u7cfb\u7edf\u5347\u7ea7\u4e2d\uff0c\u5982\u6709\u7591\u95ee\uff0c\u8bf7\u8054\u7cfb\u5ba2\u670d\uff01"), array("cate"=>"2200","itemkey"=>"regemail","itemval"=>"ON"), array("cate"=>"2200","itemkey"=>"regqq","itemval"=>"OFF"), array("cate"=>"2200","itemkey"=>"reqphone","itemval"=>"ON"), array("cate"=>"1601","itemkey"=>"sitename","itemval"=>""), array("cate"=>"2200","itemkey"=>"usereditprofile","itemval"=>"ON"), array("cate"=>"1600","itemkey"=>"username","itemval"=>""), array("cate"=>"1301","itemkey"=>"watercheckonoff","itemval"=>"ON"), array("cate"=>"1301","itemkey"=>"withdrawdaylimit","itemval"=>"3"), array("cate"=>"1301","itemkey"=>"withdrawdaymax","itemval"=>"5000000"), array("cate"=>"1301","itemkey"=>"withdrawdistribute","itemval"=>""), array("cate"=>"1301","itemkey"=>"withdrawdotyn","itemval"=>"ON"), array("cate"=>"1301","itemkey"=>"withdrawmax","itemval"=>"1000000"), array("cate"=>"1301","itemkey"=>"withdrawmin","itemval"=>"100.00"), array("cate"=>"1301","itemkey"=>"withdrawpassword","itemval"=>"OFF"));
        echo json_encode($ret);
    }
}  
  
  
?>  