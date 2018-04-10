<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>玩家流水明细 </div>
            </div>
            <div class="portlet-body">
                <form class="form-inline" style="text-align:right;" id="s_search2" action="/flow/wageredAjax">
                    <div class="form-group">
                        <input type="text" placeholder="注单号" class="form-control input-inline input-small input-sm" name="betNo" value="" />
                    </div>
                    <div class="form-group">
                        <input type="text" placeholder="账号" class="form-control input-inline input-small input-sm" name="name" value="" />
                    </div>
                    <div class="form-group">
                        <select class="table-group-action-input form-control input-inline input-sm" name="gpid" id="gpid">
                            <option value="">所有平台</option>
                            @foreach ($platforms as $gpID => $gpName)
                                <option value="{{ $gpID }}"> {{ $gpName }}</option>
                            @endforeach
                            
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="" id="TimeFli" class="table-group-action-input form-control input-inline input-sm" tabindex="1">
                            <option value="ClearDate">不筛选</option>
                            <option value="Today">今日</option>
                            <option value="Yesterday">昨日</option>
                            <option value="LastWeek">上周</option>
                            <option value="LastMonth">上月</option>
                        </select>
                        <label>开始时间</label>
                        <input type="text" name="start" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" id="start" class="form-control input-inline input-small input-sm"
                    value="{{ $startTime }}" />
                        <label>结束时间</label>
                        <input type="text" name="end" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'});" id="end" class="form-control input-inline input-small input-sm"
                            value="{{ $endTime }}" />
                    </div>
                    <div class="form-group">
                        <button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit">
                            搜索 &nbsp;
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <!--            <br><br>
        <div class="form-group">
            <a href="/flow/wagered">旧版本</a>
        </div>-->
                </form>
                <br/>
                <div class="note note-success">
                    <div>
                        <label>本页总额：</label>
                        <label>投注：</label>
                        <label class="label label-success" id="pageBet"></label>
                        <label>派彩：</label>
                        <label class="label label-success" id="pageDiv"></label>
                        <label>公司输赢：</label>
                        <label class="label label-success" id="pageWin"></label>
                        <label>有效投注：</label>
                        <label class="label label-success" id="pageFlows"></label>
                    </div>
                    <div id="rstatistic" style="padding-top: 10px;">
                        <label>搜索结果统计：</label>
                        <label>投注：</label>
                        <label class="label label-success" id="totalBet"></label>
                        <i class="fa fa-spinner fa-spin fa-fw"></i>
                        <label>派彩：</label>
                        <label class="label label-success" id="totalDiv"></label>
                        <i class="fa fa-spinner fa-spin fa-fw"></i>
                        <label>公司输赢：</label>
                        <label class="label label-success" id="totalWin"></label>
                        <i class="fa fa-spinner fa-spin fa-fw"></i>
                        <label>有效投注：</label>
                        <label class="label label-success" id="validFlows"></label>
                        <i class="fa fa-spinner fa-spin fa-fw"></i>
                    </div>
                </div>
                <table id="data2" class="table table-bordered table-striped table-condensed flip-content table-hover">
                    <thead>
                        <tr>
                            <th width="90px;">游戏平台</th>
                            <th>账号</th>
                            <th width="160px;">注单号</th>
                            <th width="80px;">下注时间</th>
                            <th>投注内容</th>
                            <th>游戏结算</th>
                            <th>下注金额</th>
                            <th>派彩金额</th>
                            <th>公司输赢</th>
                            <th>有效投注</th>
                            <th>是否有效</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>