<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>玩家资金流水 </div>
                <div class="actions">
                    <input name="fs_btype" checked onchange="set_btype(1);" type="checkbox" value="1">存款
                    <input name="fs_btype" checked onchange="set_btype(2);" type="checkbox" value="2">取款
                    <!-- <input name="fs_btype" checked onchange="set_btype(1700);" type="checkbox" value="1700">投注 -->
                    <input name="fs_btype" checked onchange="set_btype(32);" type="checkbox" value="32">红利
                    <input name="fs_btype" checked onchange="set_btype(16);" type="checkbox" value="16">返水
                    <input name="fs_btype" checked onchange="set_btype(12);" type="checkbox" value="12">转账 </div>
            </div>
            <div class="portlet-body">
                <form action="/player/fundFlowAjax" id="s_search" class="form-inline" style="text-align:right;">
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
                        <input type="text" name="s_StartTime" id="s_StartTime" class="form-control input-inline input-small input-sm datepicker"
                    placeholder="开始时间" value="{{ $startTime }}">
                    </div>
                    <div class="form-group">
                        <input type="text" name="s_EndTime" id="s_EndTime" class="form-control input-inline input-small input-sm datepicker" placeholder="结束时间"
                            value="{{ $endTime }}">
                    </div>
                    <div class="form-group">
                        <select name="s_type" id="s_type" class="table-group-action-input form-control  input-inline input-sm" tabindex="1">
                                <option value="account">账号</option>
                                <option value="name">姓名</option>
                                <option value="agentName">代理</option>
                            </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="s_btype" id="s_btype" value="1,2,32,16,12">
                        <input name="s_keyword" id="s_keyword" type="text" style="width: 120px;" placeholder="关键词" class="table-group-action-input form-control input-inline input-sm"
                        />
                    </div>
                    <div class="form-group">
                        <input name="admin" id="admin" type="text" style="width: 120px;" placeholder="客服" class="table-group-action-input form-control input-inline input-sm"
                        />
                    </div>
                    <div class="form-group">
                        <select class="table-group-action-input form-control input-inline  input-sm" tabindex="1" id="s_gpid" name="s_gpid">
                                <option value="0">不限平台</option>
                                @foreach ($platforms as $key => $val)
                                    <option value="{{ $key }}"> {{ $val }}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit">
                                搜索 &nbsp;
                                <i class="fa fa-search"></i>
                            </button>
                    </div>
                </form>
                <br/>
                <div class="note note-success">
                    <div>
                        <label>当前页统计：</label>
                        <label>存款：</label>
                        <label class="label label-success" id="pdpt"></label>
                        <label>取款：</label>
                        <label class="label label-success" id="pwtd"></label>
                        <label>红利：</label>
                        <label class="label label-success" id="pbonus"></label>
                        <label>返水：</label>
                        <label class="label label-success" id="prakeback"></label>
                        <label>转账：</label>
                        <label class="label label-success" id="ptrans"></label>
                    </div>
                    <div style="padding-top: 10px;">
                        <label>搜索结果统计：</label>
                        <label>存款：</label>
                        <label class="label label-success" id="dpt"></label>
                        <label>取款：</label>
                        <label class="label label-success" id="wtd"></label>
                        <label>红利：</label>
                        <label class="label label-success" id="bonus"></label>
                        <label>返水：</label>
                        <label class="label label-success" id="rakeback"></label>
                        <label>转账：</label>
                        <label class="label label-success" id="trans"></label>
                    </div>
                </div>
                <div style="padding-top: 5px;">
                    <p style="color: red;">注：每月的18日凌晨4点，系统将自动清除上上月的历史数据。（例如：11月18日凌晨4点，会清除10月1日0点之前的历史数据）如需保存数据，请自行复制！</p>
                </div>
                <table class="table table-bordered table-striped table-condensed flip-content table-hover" id="data">
                    <thead>
                        <tr>
                            <th style="background-color:rgb(238, 238, 238);">序号</th>
                            <th style="background-color:rgb(238, 238, 238);">账号</th>
                            <th style="background-color:rgb(238, 238, 238);">金额</th>
                            <th style="background-color:rgb(238, 238, 238);">资金</th>
                            <th style="background-color:rgb(238, 238, 238);">来源</th>
                            <th style="background-color:rgb(238, 238, 238);">记录时间</th>
                            <!-- <th>余额</th> -->
                            <th style="background-color:rgb(238, 238, 238);">操作人</th>
                            <th style="background-color:rgb(238, 238, 238);">备注</th>
                            <!-- <th>序号</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->