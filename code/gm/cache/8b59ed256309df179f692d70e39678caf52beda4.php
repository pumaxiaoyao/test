<div class="tab-pane" id="tab_2">
    
    <div class="items-content">
        <div class="item">
            <div class="form-box">
                <div class="main-account clearfix">
                    <label>主账户：</label>
                    <span class="main-account-num" gpid="MAIN" data-val=""></span>
                    <a href="javascript:void(0);" gpid="MAIN" reclaim=reclaim class="recycle-btn">一键回收
                        <span>一键回收可将所有平台余额转入主账户下
                            <em></em>
                        </span>
                    </a>
                </div>
                <form id="trans" method="post" action="/tservice/gp/transfer.jhtml">
                    <ul class="mod-retrieval m-t-30" style="padding-left: 0px;">
                        <li>
                            <label>转出</label>
                            <select name="tout" id="tout" style="width:140px;">
                                <option value="0">请选择钱包</option>
                            </select>
                            <i class="exchange-btn" style="cursor: pointer;" id="exchange"></i>
                            <label>转入</label>
                            <select name="tin" id="tin" style="width:140px;">
                                <option value="0">请选择钱包</option>
                            </select>
                            <label>金额</label>
                            <input style="ime-mode:Disabled;width:140px;" type="text" id="amount" maxlength="50" name="amount" class="txt-ipt" placeholder="输入金额"
                            />
                            <input type="button" value="转账" class="btn-sub" onclick="transfer();" />
                        </li>
                    </ul>
                </form>
                <table id="gps" width="100%" class="form-t m-t-20 platform-balance-form" style="text-align:center;">
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>