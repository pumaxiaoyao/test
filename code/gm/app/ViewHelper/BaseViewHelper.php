<?php
namespace App\ViewHelper;

use App\Core\View;

class BaseViewHelper
{
    /**
     * 角色检查框HTML
     *
     * @return void
     */
    public static function makeRoleChecker($t)
    {
        $factory = View::getView();
        return $factory->make('Common.roleCheckerCell', $t)
            ->render();
    }

    /**
     * 代理HTML
     *
     * @param [type] $roleId     玩家ID
     * @param [type] $_agentId   代理ID
     * @param [type] $_agentName 代理名
     *
     * @return void
     */
    public static function makeAgentHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.agentCell', $t)
            ->render();
    }

    /**
     * 玩家账号Html
     *
     * @return void
     */
    public static function makeAccHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.accountCell', $t)
            ->render();
    }

    /**
     * 玩家组Html
     *
     * @param [type] $data 玩家组数据
     *
     * @return void
     */
    public static function makeGroupHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.groupCell', $t)
            ->render();
    }

    /**
     * 玩家余额数据Html
     *
     * @param [type] $_balance 余额
     *
     * @return void
     */
    public static function makeBalanceHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.balanceCell', $t)
            ->render();
    }

        /**
     * 玩家红利Html
     *
     * @param [type] $_BONUS 红利数据
     *
     * @return void
     */
    public static function makeBonusHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.bonusCell', $t)
            ->render();
    }
    
    /**
     * 流水检查按钮
     *
     * @param [type] $_val 检查值
     *
     * @return void
     */
    public static function makeCheckWithDrawHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.waterCheckCell', $t)
            ->render();
    }


    /**
     * 玩家备注Html
     *
     * @param [type] $_remark 备注内容
     *
     * @return void
     */
    public static function makeRemarkHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.remarkCell', $t)
            ->render();
    }

    public static function makeCSRemarkHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.csRemarkCell', $t)
            ->render();
    }

    public static function makeWtdStatusHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.wtdCheckStatusCell', $t)
            ->render();
    }

    public static function makeWtdOperHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.wtdOperCell', $t)
            ->render();
    }
    /**
     * IP数据Html
     *
     * @param [type] $_TIME 时间
     * @param [type] $_IP   IP
     *
     * @return void
     */
    public static function makeIpHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.ipCell', $t)
            ->render();
    }



    /**
     * 玩家状态Html
     *
     * @param [type] $_code 玩家状态
     *
     * @return void
     */
    public static function makeStatusHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.statusCell', $t)
            ->render();
    }


    /**
     * 踢号Html
     *
     * @param [type] $statusCode 状态ID
     *
     * @return void
     */
    public static function makeOnlineOperHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.onlineOperCell', $t)
            ->render();
    }

    /**
     * 操作按钮HTML
     *
     * @param [type] $statusCode 状态码
     *
     * @return void
     */
    public static function makeAllOperHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.allRolesOperCell', $t)
            ->render();
    }


    /**
     * 操作按钮HTML
     *
     * @param [type] $t 参数
     *
     * @return void
     */
    public static function makeRegOperHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.regOperCell', $t)
            ->render();
    }


    public static function makeDnoCheckHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.dnoCheckCell', $t)
            ->render();
    }

    public static function makedptVerifyOperHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.dptVerifyOperCell', $t)
            ->render();
    }

    public static function makedptHistoryOperHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.dptHistoryOperCell', $t)
            ->render();
    }

    public static function makeWDBankHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.wtdBankCell', $t)
            ->render();
    }

    public static function makeFLCheckHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.flCheckCell', $t)
            ->render();
    }


    public static function makeLimitCheckHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.limitCheckCell', $t)
            ->render();
    }

    public static function makeLimitOperHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.limitOperCell', $t)
            ->render();
    }


    public static function makeAgentAccountHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.agentAccountCell', $t)
            ->render();
    }

    public static function makeAgentVerifyOperHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.agentVerifyCell', $t)
            ->render();
    }

    public static function makeDomainHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.agentDomainHtml', $t)
            ->render();
    }

    public static function makeAgentNoteHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.agentRemarkHtml', $t)
            ->render();
    }

    public static function makeAgentlistOperHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.agentListOperCell', $t)
            ->render();
    }
    
    public static function makeDomainOperHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.domainDeleteCell', $t)
            ->render();
    }

    public static function makeCurPeriodOperHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.curPeriodOperBtn', $t)
            ->render();
    }

    public static function makeAdjustBtnCellHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.adjustBtnCell', $t)
            ->render();
    }

    public static function makeResultBtnCellHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.resultBtnCell', $t)
            ->render();
    }

    public static function makeWtdRemarkHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.agentWtdRemarkCell', $t)
            ->render();
    }


    public static function makeAgentWtdOperHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.agentWtdOperCell', $t)
            ->render();
    }

    public static function makeAgWtdBankOperHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.agWtdBankOper', $t)
            ->render();
    }

    public static function makeActListOperHtml($t)
    {
        $factory = View::getView();
        return $factory->make('Common.activityListOperCell', $t)
            ->render();
    }
}
