<?php

trait fundsViewCommonMethod{
    
    function makeHistoryHtml($historyData){
        /**
         * 构建历史交易记录界面
         */
        if(empty($historyData) || getArrayValue("size", 0, $historyData) == 0){
            return false;
        }
        $allHtml = "";
        foreach($historyData["data"] as $_history){
            $_html = "<tr><td>".getArrayValue("recordNum", 0, $_history)."</td>";
            $_html = $_html."<td>".parseDate(getArrayValue("time", time(), $_history))."</td>";
            $_html = $_html."<tr><td>".getArrayValue("applyId", 0, $_history)."</td>";
            $_html = $_html."<tr><td>".getArrayValue("oddType", 0, $_history)."</td>";
            $_html = $_html."<tr><td>".getArrayValue("amount", 0, $_history)."</td>";
            $_html = $_html."<tr><td>".getArrayValue("status", 0, $_history)."</td></tr>";
            $allHtml = $allHtml.$_html; 
        }
        return $allHtml;


    }
    
    function makeBankInfoPage($bankinfos){
        $page = readHtml("member/accountsetting_funds/funds_withdrawal");
        $allCards = "";
        for($x=0;$x<count($bankinfos);$x++){
            $_html = '';
            $_card = $bankinfos[$x];

            if ($x === 0){
                $_html = '<label class="on"  style="border: 1px solid #c8cccf; width: 300px">
                            <input type="radio" checked  name="bankradiogroup" value="%VALUE%"/>
                            <b>%BANK% %CARD%</b></label>';
            }else{
                $_html = '<label style="border: 1px solid #c8cccf; width: 300px">
                <input type="radio"  name="bankradiogroup" value="%VALUE%"/><b>
                    %BANK% %CARD%</b></label>';
            }
            // $_html = str_replace("%CARDID%", $_card["id"], $_html);
            $_html = str_replace("%BANKSN%", $_card["banksn"], $_html);
            $_html = str_replace("%VALUE%", $_card["value"], $_html);
            $_html = str_replace("%BANK%", $_card["name"], $_html);
            $_html = str_replace("%CARD%", "&nbsp; ****&nbsp; ****&nbsp; ****&nbsp; ".substr($_card["card"], -4), $_html);
            // $_html = .$_html."</i>";
            $allCards = $allCards.$_html;
        }
        return str_replace("%ALLCARDSINFO%", $allCards, $page);
    }

    /**
     * 构建前台的银行卡界面数据
     *
     * @param [type] $bankinfos 银行卡数据
     * 
     * @return void
     */
    static function makeCardsInfoPage($bankinfos)
    {
        $page = readHtml("member/accountsetting_funds/funds_bankmanager");
        $allCards = "";
        for ($x=0;$x<count($bankinfos);$x++) {
            $_html = '<li><i class="%BANKSN%"></i>%BANKNAME% (尾号%BANKCARD%)<a onclick="delbank(this, %CARDVALUE%)">删除</a></li>';
            $_card = $bankinfos[$x];
            $_html = str_replace("%BANKSN%", $_card["banksn"], $_html);
            $_html = str_replace("%BANKNAME%", $_card["name"], $_html);
            $_html = str_replace("%BANKCARD%", substr($_card["card"], -4), $_html);
            $_html = str_replace("%CARDVALUE%", $_card["value"], $_html);
            $allCards = $allCards.$_html;
        }
        $page = str_replace("%RealName%", urldecode($_SESSION["memberinfo"]["RealName"]), $page);
        $page = str_replace("%BANKCARDLIST%", $allCards, $page);

        return str_replace("%BANKCARDLIST%", $allCards, $page);
    }
    
    
}

?>