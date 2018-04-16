
    <div class="page-content-wrapper">
            <div class="page-content" id="a_pageContent">
                
    <div class="content">
        <div class="layout">
            <div>
                <form class="form" method="get" action="/report/agentDaily">
                    <input type="text" name="agentname"  placeholder="代理"
                           value=""/>
                    <label>开始时间</label>
                    <input type="text" name="start" id="start" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                value="{{ $startDate }}"/>
                    <label>结束时间</label>
                    <input type="text" name="end" id="end" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                value="{{ $endDate }}"/>
                    <input type="submit" class="btn-sub" value="查找"/>
                </form>
            </div>
            <div style="padding-top: 10px;">
                <p style="color: red;">注：此报表数据每15分钟自动更新一次。存（取）款额，包含客服手工添加存（取）款金额以及玩家存（取）款操作金额。<br />每月的18日凌晨4点，系统将自动清除上上月的历史数据。（例如：11月18日凌晨4点，会清除10月1日0点之前的历史数据）如需保存数据，请自行复制！            </p>
            </div>
            <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                <thead>
                <tr>
                    <th>代理</th>
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
                    <th>公司收入</th>
                    <th>更新时间</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($statics as $data)
                        <tr>
                        <td>{{ $data["account"] }}</td>
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
                        <td>{{ date("Y-m-d H:i:s", $data["updateTime"]) }}</td>
                        </tr>
                    @endforeach
                </tbody>

                {{-- <tr style="background-color:#FFEEDD;">
                    <td>汇总</td>
                    <td style="text-align:right;">151</td>
                    <td style="text-align:right;">1235</td>
                    <td style="text-align:right;">1036</td>
                    <td style="text-align:right;">87</td>
                    <td style="text-align:right;">59,680.00</td>
                    <td style="text-align:right;">2,052,400.92</td>
                    <td style="text-align:right;">1,898,381.33</td>
                    <td style="text-align:right;">16,014,311.85</td>
                    <td style="text-align:right;" class="cGreen">326,485.51</td>
                    <td style="text-align:right;">14,466.30</td>
                    <td style="text-align:right;">69,644.92</td>
                    <td style="text-align:right;">15,433.50</td>
                    <td style="text-align:right;"
                        class="cGreen">226,940.78</td>
                    <td>/</td>
                </tr> --}}
            </table>
        </div>
    </div>        </div>
        </div>
        <!-- END CONTENT -->
    
    </div>
    <!-- END CONTAINER -->
    
    