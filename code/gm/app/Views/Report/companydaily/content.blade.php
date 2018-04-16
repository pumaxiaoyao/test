<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">

        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>公司输赢报表
                </div>
                <div class="actions">
                </div>
            </div>
            <div class="portlet-body">
                <form action="/report/companyDaily" id="s_search" class="form-inline" style="text-align:right;">
                    <div class="form-group">
                        <label>开始</label>
                        <input type="text" class="form-control input-sm" readonly="readonly" name="start" id="start" onclick='WdatePicker({dateFmt:"yyyy-MM-dd"})'
                    value="{!! $startDate !!}" />
                    </div>
                    <div class="form-group">
                        <label>结束</label>
                        <input type="text" class="form-control input-sm" readonly="readonly" name="end" id="end" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                    value="{!! $endDate !!}" />
                    </div>
                    <div class="form-group">
                        <button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit">
                        搜索 &nbsp; <i class="fa fa-search"></i>
                    </button>
                    </div>
                </form>
                <div style="padding-top: 10px;">
                    <p style="color: red;">注：此报表数据每15分钟自动更新一次。存（取）款额，包含客服手工添加存（取）款金额以及玩家存（取）款操作金额。<br/> 每月的18日凌晨4点，系统将自动清除上上月的历史数据。（例如：11月18日凌晨4点，会清除10月1日0点之前的历史数据）如需保存数据，请自行复制！
                        </p>
                </div>
                <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                    <thead>
                        <tr>
                            <th>日期</th>
                            <th>注册数</th>
                            <th>登录数</th>
                            <th>存款数</th>
                            <th>首存数</th>
                            <th>首存额</th>
                            <th>存款额</th>
                            <th>取款额</th>
                            <th>投注额</th>
                            <th>公司输赢</th>
                            <th>红利</th>
                            <th>返水</th>
                            <th>存款优惠</th>
                            <th>其它费用</th>
                            <th>公司收入</th>
                            <th>更新时间</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($statics as $data)
                            <tr>
                            <td>{{ $data["day"] }}</td>
                            <td>{{ $data["joinCount"] }}</td>
                            <td>{{ $data["loginCount"] }}</td>
                            <td>{{ $data["depositTimes"] }}</td>
                            <td>{{ $data["firstDepositTimes"] }}</td>
                            <td>{{ $data["firstDepositAmount"] }}</td>
                            <td>{{ $data["depositAmount"] }}</td>
                            <td>{{ $data["withdrawalAmount"] }}</td>
                            <td>{{ $data["stakeAmount"] }}</td>
                            <td>{{ $data["winLoseAmount"] }}</td>
                            <td>{{ $data["bonusAmount"] }}</td>
                            <td>{{ $data["rebateAmount"] }}</td>
                            <td>{{ $data["depositBonusAmount"] }}</td>
                            <td>0</td>
                            <td>0</td>
                            <td>{{ date("Y-m-d H:i:s", $data["updateTime"]) }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->

</div>
<!-- END CONTAINER -->