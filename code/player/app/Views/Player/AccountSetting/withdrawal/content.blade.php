<div class="nr_history_right">
    <div class="tk_nr">
        @if (count($cards) == 0)
            <div class="withdrawal_bindinfo">
                <img src="/static/img/player/bigwarn_icon.png" /> <br />
                <span>为了阁下的资金安全，在进行提款操作时，我们需要验证阁下的个人信息。</span><br />
                <span>请尽快<a href="/player/BankManager">绑定银行卡</a></span>
            </div>
        @else
        <div class="tk_title">
            <h3>提款</h3><span>通常您的提款只需3-15分钟即可到账，若超过30分钟仍未到账，请联系在线客服核查。</span>
        </div>
        <div class="tk_box">
            <div class="tk_jr"><span class="text">提款金额：</span><span class="input"><input name="ctl01" id="withdrawalMoney" type="number" onKeyUp="amount(this)" onBlur="overFormat(this)" placeholder="金额" class="r_inptut inputwd300" /></span></div>
            <div class="tk_ts"><span id="withdrawalMoney_tips" class="text">最低提款值金额不能低于100元</span></div>
            <div class="tk_yh"><span class="text">选择银行：</span>
                <span class="radio">
                    <!-- <div class="deposit_atmsel_icon_i">         -->
                    @foreach ($cards as $card)
                        @if ($loop->first)
                    <label style="border: 1px solid #c8cccf; width: 300px" class="on" for="bankradiogroup{{ $card["id"] }}" > <input checked
                        @else
                            <label style="border: 1px solid #c8cccf; width: 300px" for="bankradiogroup{{ $card["id"] }}" > <input
                        @endif
                            id="bankradiogroup{{ $card["id"] }}" type="radio" name="bankradiogroup" value="{{ $card["id"] }}"/>
                            <b>{{ $card["name"] }} {!! $card["cardNo"] !!}</b></label>
                        
                    @endforeach
                    <!-- </div> -->
                </span>
            </div>
            <div><button type="button" id="withdrawal_submit" class="as_but inputwd300">提交提款</button></div>
        </div>
        @endif
    </div>
</div>
</div>
</div>