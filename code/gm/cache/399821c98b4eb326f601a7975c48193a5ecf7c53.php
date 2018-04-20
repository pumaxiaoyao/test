<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>玩家返水历史 </div>
            </div>
            <div class="portlet-body">
                <form action="/flow/getRakeBackHistory" id="s_search" class="form-inline" style="text-align:right;">
                    <div>
                        <a class="btn btn-m blue table-group-action-submit" onclick="makewaterlist();">生成当日测试返水数据
                            <i class="m-icon-swapright m-icon-white"></i>
						</a>
                    </div>
                    <div class="form-group">
                        <select name="" id="s_TimeFli" class="table-group-action-input form-control input-inline input-sm" tabindex="1">
							<option value="ClearDate">不筛选</option>
							<option value="Today">今日</option>
							<option value="Yesterday">昨日</option>
							<option value="LastWeek">上周</option>
							<option value="LastMonth">上月</option>
						</select>
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?php echo e($startTime); ?>" name="s_StartTime" id="s_StartTime" class="form-control input-inline input-small input-sm datepicker"
                            placeholder="开始时间">
                    </div>
                    <div class="form-group">
                        <input type="text" value="<?php echo e($endTime); ?>" name="s_EndTime" id="s_EndTime" class="form-control input-inline input-small input-sm datepicker"
                            placeholder="结束时间">
                    </div>
                    <div class="form-group">
                        <select name="s_type" id="s_type" class="table-group-action-input form-control input-small input-sm" tabindex="1">
							<option value="account">账号</option>
							<option value="name">姓名</option>
							<option value="agentAccount">代理</option>
						</select>
                    </div>
                    <div class="form-group">
                        <input name="s_keyword" id="s_keyword" type="text" placeholder="关键词" class="table-group-action-input form-control input-inline input-sm"
                        />
                    </div>
                    <div class="form-group">
                        <button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit">
							搜索 &nbsp;
							<i class="fa fa-search"></i>
						</button>
                    </div>
                </form>
                <div style="padding-top: 10px;">
                    <p style="color: red;">注：每月的18日凌晨4点，系统将自动清除上上月的历史数据。（例如：11月18日凌晨4点，会清除10月1日0点之前的历史数据）如需保存数据，请自行复制！</p>
                </div>
                <table class="table table-striped table-bordered table-hover table-full-width" id="data">
                    <thead>
                        <tr>
                            <th>结算日期</th>
                            <th>账号</th>
                            <th>姓名</th>
                            <th>玩家组</th>
                            <th>代理</th>
                            <th>平台</th>
                            <th>下注次数</th>
                            <th>投注总流水</th>
                            <th>派彩总额</th>
                            <th>返水额</th>
                            <th>结算</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->