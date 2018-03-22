<?php  
  
/** 
 * 玩家资金管理模块
 */  

registerDataHelper(array("protoHelper", "dataHelper"));
registerViewHelper(array("GmViewHelper", "playerfund/playerFundViewHelper","playerfund/dptVerifyViewHelper"));
registerCtrlHelper(array("playerfund/playerfundtrait"));

/**
 * 玩家资金模块入口
 */
class Playerfund
{
    use Playerfundtrait;

    /**
     * 存款审核
     *
     * @return void
     */
    static function dptVerify()
    {
        ShowDptVerify(__CLASS__);
    }

    /**
     * 存款历史
     *
     * @return void
     */
    static function dptHistory()
    {
        ShowDptHistory(__CLASS__);
    }

    /**
     * 存款调整
     *
     * @return void
     */
    static function dptCorrection()
    {
        ShowDptCorrection(__CLASS__);
    }

    /**
     * 取款审核
     *
     * @return void
     */
    static function wtdVerify()
    {
        ShowWtdVerify(__CLASS__);
    }

    /**
     * 取款历史
     *
     * @return void
     */
    static function wtdHistory()
    {
        ShowWtdHistory(__CLASS__);
    }

    /**
     * 流水明细
     *
     * @return void
     */      
    static function flowLimit()
    {
        ShowFlowLimit(__CLASS__);
    }
    
    /**
     * 转账记录
     *
     * @return void
     */
    static function transferList()
    {
        ShowTransferList(__CLASS__);
    }



    
}
?>