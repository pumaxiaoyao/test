<div class="page-content-wrapper">
    <div class="page-content" id="a_pageContent">
        <div class="tabbable tabbable-custom boxless">
            <ul class="title nav nav-tabs">
                <li class="active">
                    <a href="#tab_1" data-toggle="tab">玩家信息</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="portlet-body form">
                        <h3 class="form-section">{{ $account or "" }} </h3>
                        <form action="#" id="playerdetail" class="horizontal-form">
                            <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                                <thead id="_thead"></thead>
                                <tbody id="_tbody"></tbody>
                            </table>
                            <table class="table table-bordered table-striped table-condensed flip-content table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="4">
                                            玩家信息 </th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td>
                                        <label class="control-label">姓名:</label>
                                    </td>
                                    <td>
                                        <input type="text" id="realname" name="realname" value="{{ $name or " " }}" class="form-control input-sm" placeholder="">
                                    </td>
                                    <td>
                                        <label class="control-label">玩家组:</label>
                                    </td>
                                    <td>
                                        <span class="text">{{ $layer or ""  }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="control-label">状态:</label>
                                    </td>
                                    <td>
                                        <span class="text">{{ $status or "" }}</span>
                                    </td>
                                    <td>
                                        <label class="control-label">代理编号:</label>
                                    </td>
                                    <td>
                                        <span class="text ">{{ $agent or "" }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="control-label">QQ:</label>
                                    </td>
                                    <td>
                                        <input type="text" id="qq" name="qq" value="{{ $qq or " " }}" class="form-control input-sm" placeholder="">
                                    </td>
                                    <td>
                                        <label class="control-label">手机号:</label>
                                    </td>
                                    <td>
                                        <input name="mobile" id="mobile" class="form-control input-sm" value="{{ $cellPhoneNo or " " }}" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="control-label">出生日期:</label>
                                    </td>
                                    <td>
                                        <input type="text" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})" id="birthday" readonly name="birthday" value="" class="form-control input-sm"
                                            placeholder="">
                                    </td>
                                    <td>
                                        <label class="control-label">邮箱:</label>
                                    </td>
                                    <td>
                                        <input type="text" name="email" id="email" class="form-control" value="{{ $email or " "}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="control-label">注册时间:</label>
                                    </td>
                                    <td>
                                        <span class="text">{{ $joinTime or "" }}</span>
                                    </td>
                                    <td>
                                        <label class="control-label">注册IP:</label>
                                    </td>
                                    <td>
                                        <span class="text">{{ $joinIp or "" }} </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="control-label">上次登录日期:</label>
                                    </td>
                                    <td>
                                        <span class="text">{{ $lastLoginTime or "" }} </span>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                            <div class="form-actions">
                                <button type="button" onclick="saveplayerdetail('{{ $account or " " }}');" class="btn blue">
                                        <i class="icon-ok"></i> 保存 </button>
                                <button type="button" onclick="javascript:history.go(-1);" class="btn">取消</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>