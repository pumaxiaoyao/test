<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">

        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-globe"></i>玩家活跃度
                </div>
                <div class="actions">
                    <div class="btn-group">
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <form class="form-inline" style="text-align:left;" id="s_search" action="/report/playerActivityAjax">
                    <div class="form-group">
                        <label>存款次数：</label>
                        <input type="text" class="form-control input-inline input-mini input-sm" name="count_low" value="" />~
                        <input type="text" class="form-control input-inline input-mini input-sm" name="count_up" value="" />
                    </div>
                    <div class="form-group">
                        <label>存款金额：</label>
                        <input type="text" class="form-control input-inline input-xsmall input-sm" name="amount_low" value="" />~
                        <input type="text" class="form-control input-inline input-xsmall input-sm" name="amount_up" value="" />
                    </div>
                    <div class="form-group">
                        <label>取款次数：</label>
                        <input type="text" class="form-control input-inline input-mini input-sm" name="count2_low" value="" />~
                        <input type="text" class="form-control input-inline input-mini input-sm" name="count2_up" value="" />
                    </div>
                    <div class="form-group">
                        <label>取款金额：</label>
                        <input type="text" class="form-control input-inline input-xsmall input-sm" name="amount2_low" value="" />~
                        <input type="text" class="form-control input-inline input-xsmall input-sm" name="amount2_up" value="" />
                    </div>
                    <br />
                    <br />
                    <label>开始</label>
                    <div class="form-group">
                        <input type="text" name="start" id="start" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="form-control input-inline input-small input-sm"
                            value="2017-10-12 00:00:00" />
                        <label>结束</label>
                        <input type="text" name="end" id="end" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})" class="form-control input-inline input-small input-sm"
                            value="2017-10-13 23:59:59" />
                    </div>
                    <div class="form-group">
                        <select id="groupId" name="groupId" class="table-group-action-input form-control input-sm" tabindex="1">
                        <option value="0">所有层级</option>
                                                <option value="7">注册默认</option>
                                                <option value="5">初级会员</option>
                                                <option value="6">中级会员</option>
                                                <option value="2">高级会员</option>
                                                <option value="1">不送返水优惠</option>
                                                <option value="3">测试层级</option>
                                        </select>
                    </div>
                    <div class="form-group">
                        <select id="s_type" name="s_type" class="table-group-action-input form-control input-sm" tabindex="1">
                        <option value="name">玩家账号</option>
                        <option value="agent">代理账号</option>
                    </select>
                    </div>
                    <div class="form-group">
                        <input name="s_keyword" type="text" placeholder="关键词" class="table-group-action-input form-control input-inline input-sm"
                        />
                    </div>
                    <div class="form-group">
                        <button type="submit" id="s_submit" class="btn btn-sm green table-group-action-submit">
                        搜索 &nbsp; <i class="fa fa-search"></i>
                    </button>
                    </div>
                </form>
                <div style="padding-top: 10px;">
                    <p style="color: red;">注：此表的时间筛选条件是以存款次数大于0的用户作为筛选，表内数据展示用户在筛选时间内所有数据。</p>
                    <p style="color: red;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;每月的18日凌晨4点，系统将自动清除上上月的历史数据。（例如：11月18日凌晨4点，会清除10月1日0点之前的历史数据）如需保存数据，请自行复制！</p>
                </div>
                <table id="data" class="table table-bordered table-striped table-condensed flip-content table-hover">
                    <thead>
                        <tr>
                            <th><input type="checkbox" value="" id="selAll" /></th>
                            <th>玩家账户</th>
                            <th width="100">真实姓名</th>
                            <th>层级</th>
                            <th>代理</th>
                            <th width="100">注册时间</th>
                            <th>主账户余额</th>
                            <th>存款金额</th>
                            <th>存款次数</th>
                            <th>取款金额</th>
                            <th>取款次数</th>
                            <th>红利</th>
                            <th>返水</th>
                            <th>投注</th>
                            <th>派彩</th>
                            <th>公司输赢</th>
                            <th>有效投注</th>
                            <th>状态</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <div class="modal fade" id="batchLayerModal" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal">×</button>
                        <h3>调整玩家组:
                            <font show=uname></font>
                        </h3>
                    </div>
                    <div class="modal-body">
                        <table id="data" class="table table-bordered table-striped table-condensed flip-content table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>序号</th>
                                    <th>玩家组</th>
                                    <th>是否默认</th>
                                    <th>状态</th>
                                    <th>备注</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>注册默认</td>
                                    <td>是</td>
                                    <td>启用</td>
                                    <td></td>
                                    <td>
                                        <a href="javascript:void(0);" group="group" groupname="注册默认" groupid="7" class="btn btn-xs grey-cascade">立即选择</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>初级会员</td>
                                    <td>否</td>
                                    <td>启用</td>
                                    <td>初级会员</td>
                                    <td>
                                        <a href="javascript:void(0);" group="group" groupname="初级会员" groupid="5" class="btn btn-xs grey-cascade">立即选择</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>中级会员</td>
                                    <td>否</td>
                                    <td>启用</td>
                                    <td>中级会员</td>
                                    <td>
                                        <a href="javascript:void(0);" group="group" groupname="中级会员" groupid="6" class="btn btn-xs grey-cascade">立即选择</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>高级会员</td>
                                    <td>否</td>
                                    <td>启用</td>
                                    <td>高级会员</td>
                                    <td>
                                        <a href="javascript:void(0);" group="group" groupname="高级会员" groupid="2" class="btn btn-xs grey-cascade">立即选择</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>不送返水优惠</td>
                                    <td>否</td>
                                    <td>启用</td>
                                    <td>首存会员</td>
                                    <td>
                                        <a href="javascript:void(0);" group="group" groupname="不送返水优惠" groupid="1" class="btn btn-xs grey-cascade">立即选择</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>测试层级</td>
                                    <td>否</td>
                                    <td>启用</td>
                                    <td>测试</td>
                                    <td>
                                        <a href="javascript:void(0);" group="group" groupname="测试层级" groupid="3" class="btn btn-xs grey-cascade">立即选择</a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->

</div>
<!-- END CONTAINER -->