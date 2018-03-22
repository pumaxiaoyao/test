<?php

/**
 * Nothin to say
 */
registerDataHelper(array("protoHelper", "dataHelper"));
/**
 * Common module
 */
class Common
{
    /**
     * Undocumented function
     *
     * @param [type] $request request
     * 
     * @return void
     */
    static function httpsRequest($request)
    {
        $_PostData = file_get_contents('php://input');
        $url =  substr($_PostData, 4);
        if (!empty($url)) {
            if (strstr($url, "%")) {
                $url = urldecode($url);
            }
            $ret = curlHttpsGet($url);
            return output($ret);
        }
        
    }
}
?>