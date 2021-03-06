<div class="tab-pane" id="tab_3">
    <form action="/player/fundList" id="s_search" class="form-inline" style="text-align:right; margin-bottom: 10px;">
        <div class="form-group" style="text-align:center; margin-right: 15px;">
            <label class="checkbox-label"><input inbox="btype" type="checkbox" value="Deposit" checked="checked">存款</label>
            <label class="checkbox-label"><input inbox="btype" type="checkbox" value="Withdrawal" checked="checked">取款</label>
            <label class="checkbox-label"><input inbox="btype" type="checkbox" value="Adjustment" checked="checked">红利</label>
            <label class="checkbox-label"><input inbox="btype" type="checkbox" value="Rebate" checked="checked">返水</label>
            <label class="checkbox-label"><input inbox="btype" type="checkbox" value="Transfer" checked="checked">转账</label>
        </div>
        <div class="form-group">
            <select name="" id="box_StatusFli" class="table-group-action-input form-control input-inline input-sm" tabindex="1">
                    <option value="1">成功</option>
                    <option value="0">失败</option>
                </select>
        </div>
        <div class="form-group">
            <input type="text" name="box_DnoNo" id="box_DnoNo" class="form-control input-inline input-small input-sm" placeholder="单号">
        </div>
        <div class="form-group">
            <select name="" id="s_TimeFliBox" class="table-group-action-input form-control input-inline input-sm" tabindex="1">
                    <option value="ClearDate">不筛选</option>
                    <option value="Today">今日</option>
                    <option value="Yesterday">昨日</option>
                    <option value="LastWeek">上周</option>
                    <option value="LastMonth">上月</option>
                </select>
        </div>
        <div class="form-group">
            <input type="text" name="box_StartTime" id="box_StartTime" value="{!! $startTime !!}" class="form-control input-inline input-small input-sm datepicker"
                placeholder="开始时间">
        </div>
        <div class="form-group">
            <input type="text" name="box_EndTime" id="box_EndTime" value="{!! $endTime !!}" class="form-control input-inline input-small input-sm datepicker"
                placeholder="结束时间">
        </div>
        <div class="form-group">
            <button type="button" id="box_ffs" uid="{{ $account }}" class="btn btn-sm green table-group-action-submit">
                    搜索 &nbsp; <i class="fa fa-search"></i>
                </button>
        </div>
    </form>
    <table id="box_fftable" class="table table-striped table-bordered table-hover table-full-width">
        <thead>
            <tr>
                <th>序号</th>
                <th>类型</th>
                <th>单号</th>
                <th>金额</th>
                <th>备注</th>
                <th>客服</th>
                <th>时间</th>
                <th>状态</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>