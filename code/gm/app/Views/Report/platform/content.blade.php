<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">


        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>游戏输赢汇总
                </div>
                <div class="actions">
                    <!--            <a class="btn blue small" href="/report/otherFee?type=pt">PT累计奖池</a>-->
                </div>
            </div>
            <div class="portlet-body">
                <form action="/report/platform" id="s_search" class="form-inline" style="text-align:right;">
                    <div class="form-group">
                        <label>开始</label>
                        <input type="text" class="table-group-action-input form-control input-inline input-sm" name="start" id="start" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                    value="{{ $startDate }}" />
                    </div>
                    <div class="form-group">
                        <label>结束</label>
                        <input type="text" class="table-group-action-input form-control input-inline input-sm" name="end" id="end" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                    value="{{ $endDate }}" />
                    </div>
                    <div class="form-group">
                        <button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit">
                                    搜索 &nbsp;
                                    <i class="fa fa-search"></i>
                                </button>
                    </div>
                </form>
                <div style="padding-top: 10px;">
                    <p style="color: red;">注：此报表数据每15分钟自动更新一次。
                        <br/>每月的18日凌晨4点，系统将自动清除上上月的历史数据。（例如：11月18日凌晨4点，会清除10月1日0点之前的历史数据）如需保存数据，请自行复制！</p>
                </div>
                <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th>游戏平台</th>
                            <th>投注人数</th>
                            <th>投注次数</th>
                            <th>投注额</th>
                            <th>公司输赢</th>
                            <th>返水</th>
                            <th>人均投注额</th>
                            <th>人均投注次数</th>
                            <th>更新时间</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($statics as $data)
                            <tr>
                                <td>{{ $loop->index }}</td>
                                <td>{{ $data["game"] }}</td>
                                <td>{{ $data["stakePlayerCount"] }}</td>
                                <td>{{ $data["stakeTimes"] }}</td>
                                <td>{{ $data["stakeAmount"] }}</td>
                                <td>{{ $data["winLoseAmount"] }}</td>
                                <td>{{ $data["rebateAmount"] }}</td>
                                <td>{{ $data["stakeAmount"] / $data["stakePlayerCount"]}}</td>
                                <td>{{ $data["stakeTimes"] / $data["stakePlayerCount"]}}</td>
                                <td>{{ date("Y-m-d H:i:s", $data["updateTime"]) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
{{-- 
                    <tr style="background-color:#FFEEDD;">
                        <td>/</td>
                        <td>汇总</td>
                        <td style="text-align:right;">1070</td>
                        <td style="text-align:right;">139153</td>
                        <td style="text-align:right;">16,014,311.85</td>
                        <td class="cGreen" style="text-align:right;">326,485.50</td>
                        <td style="text-align:right;">69,644.92</td>
                        <td style="text-align:right;">14,966.65</td>
                        <td style="text-align:right;">130.05</td>
                        <td>/</td>
                    </tr> --}}
                </table>
                <!--        <table class="table table-bordered table-striped table-condensed flip-content table-hover">-->
                <!--            <tr>-->
                <!--                <th>项目</th>-->
                <!--                <th>累计奖池派彩</th>-->
                <!--                <th>累计奖池扣费</th>-->
                <!--                <th>合计</th>-->
                <!--            </tr>-->
                <!--            <tr>-->
                <!--                <td>pt累计奖池</td>-->
                <!--                <td>-->
                <!--</td>-->
                <!--                <td>-->
                <!--</td>-->
                <!--                <td>-->
                <!--</td>-->
                <!--            </tr>-->
                <!--        </table>-->
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->

</div>
<!-- END CONTAINER -->