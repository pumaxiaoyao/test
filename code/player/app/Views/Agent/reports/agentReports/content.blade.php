<div class="as_fl20_right">

        <div class="as_fr80">
            <div style="padding:0px 10px;">
                <div id="setting_agentreports_box" class="setting_box_div">
                    <div class="as_bet_zz">
                        <div class="as_bet_zz_title1">
                            <h3>下线代理列表
                                <b>| 管理下线的代理数据。</b>
                                
                                @if ($lvl < 3)
                                <button onclick="addNewAgent()" style="float:right;" class="addAgentbtn addAgentbtnbg"><span>新增代理</span></button>
                                @endif
                            </h3>
                        </div>
                        <div class="as_bet_zz_table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>序号</th>
                                        <th width="17%">代理账号</th>
                                        <th width="17%">真实姓名</th>
                                        <th>注册日期</th>
                                        <th>代理层级</th>
                                        <th width="10%">代理编码</th>
                                        <th width="10%">会员总数</th>
                                        <th width="10%">状态</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agentReportsData as $_data)
                                        <tr>
                                            <td>{{ $_data["id"] or "" }}</td>
                                            <td>{{ $_data["account"] or "" }}</td>
                                            <td>{{ $_data["name"] or "" }}</td>
                                            <td>{{ $_data["time"] or "" }}</td>
                                            <td>{{ $_data["layer"] or "" }}</td>
                                            <td>{{ $_data["roleId"] or "" }}</td>
                                            <td>{{ $_data["memgberCount"] or "" }}</td>
                                            <td>{{ $_data["stag"] or "" }}</td>
                                        </tr>
                                    @endforeach
    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
    </div>