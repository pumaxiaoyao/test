<?php  
/** 
 * MVC路由功能简单实现 
 * @desc 简单实现MVC路由功能  
 */
registerDataHelper(array("protoHelper", "dataHelper"));

class Bc  
{   
    static function mt()
    {   
        $RequestArgs = getSessionValue("QueryArgus", "");
        $errorRet = $GLOBALS["errorRet"];
        if(empty($RequestArgs)){
            return $errorRet;
        }
        $ra_new = getArrayValue("new", "", $RequestArgs);
        $ra_tps = getArrayValue("tps", "", $RequestArgs);
        $ra_ = getArrayValue("_", "", $RequestArgs);
        if (empty($ra_new) || empty($ra_tps) || empty($ra_)){
            return $errorRet;
        }else{
            output(Base_getMsgStatus($ra_new, $ra_tps, $ra_), "json");
        }
    }
    function login($args)
    {
        output(Base_login(), "json");
    }
}  
  
  
?>  
