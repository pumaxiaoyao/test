<div class="nr_history_right">
    <div class="tk_nr bank_manage">
        @if (!$RealName)
            <div class="withdrawal_bindinfo">
                <img src="/static/img/player/bigwarn_icon.png" /> <br />
                <span>为了阁下的资金安全，绑定银行卡前，我们需要验证阁下的个人信息。</span><br />
                <span>请尽快<a href="/agent/accountSetting">个人信息</a></span>
            </div>
        @elseif (!$Phone)
            <div class="withdrawal_bindinfo">
                <img src="/static/img/player/bigwarn_icon.png" /> <br />
                <span>为了阁下的资金安全，绑定银行卡前，我们需要验证阁下的手机号码。</span><br />
                <span>请尽快<a href="/agent/accountSetting?setting=phone">手机号码</a></span>
            </div>
        @else
        <div class="tk_title" style="height: 72px;line-height: 72px;">
            <h3>银行卡管理</h3>
        </div>
        <div class="manage_box_two">
            <ul>
                @foreach($cards as $idx=> $card)
                <li>
                    <i class="{{ $card["sn"] }}"></i>
                    {{ $card["name"]}} (尾号{{ $card["cardNo"]}})
                    <a onclick="delbank(this, {{ $card["id"] }})">删除</a>
                </li>
                @endforeach
            </ul>
            <div class="add_bank">
                <span id="add_bank">添加一张银行卡</span>
            </div>
        </div>
        <div style="margin-bottom:30px; display:none;" class="manage_box_three">
            <div class="binding_info">
                <h3>添加银行卡</h3>
                <div class="bank_info">
                    <span>
                            <b>银行卡卡号:</b>
                            <div>
                            <input type="text" id="BankNo" class="r_inptut inputwd300" />
                            </div>
                        </span>
                    <span>
                            <b>持卡人姓名:</b>
                            <div>
                            <input value="{{ $RealName or "" }}" id="RealName" readonly type="text" class="r_inptut inputwd300" />
                            </div>
                        </span>
                    <span>
                            <b>开户银行:</b>
                            <div>
                                <select id="BankType" class="r_inptut inputwd300">
                                    <option value="">开户银行 </option>
    
                                    <option value="1">中国银行</option>
    
                                    <option value="2">建设银行</option>
    
                                    <option value="3">工商银行</option>
    
                                    <option value="4">农业银行</option>
    
                                    <option value="5">招商银行</option>
    
                                    <option value="6">民生银行</option>
    
                                    <option value="10">中信银行</option>
    
                                    <option value="11">华夏银行</option>
    
                                    <option value="12">光大银行</option>
    
                                    <option value="15">兴业银行</option>
    
                                </select>
                            </div>
                        </span>
                </div>
                <div class="city_info">
                    <span><b>开户地址:</b>
                            <div>
                            <input type="text" id="RegBank" class="r_inptut inputwd300" />
                            </div>
                        </span>
                </div>
                <br/>
                <div class="binding_yzm">
                    <span>验证码:</span>
                    <div>
                        <input id="code_text" type="text" class="r_inptut inputwd300" />
                        <b id="GetCodeBt">获取验证码</b>
                        <b id="GetTime" style="display: none; ">
                                <span class="time_sec" id="Timing">60</span> 秒后重新发送</b>
                    </div>
                </div>
                <div>
                    <button type="button" style="margin-left:0px;" id="addbank_bt" class="as_but inputwd300">添加银行卡</button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
</div>
</div>