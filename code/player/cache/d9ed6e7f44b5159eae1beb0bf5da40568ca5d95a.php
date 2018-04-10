<script>

    var loginMemberName = '<?php echo e($LoginMemberName); ?>';
    
    var thirdPaymentId = 'ruyeeWeb01';
    var thirdNotMaintain = 1;
    var thirdAvailable = 1;
    

    var wechatPaymentId = 'ruyeeWeixin01';
    var wechatNotMaintain = 0;
    var alipayPaymentId = '';
    var alipayNotMaintain = 0;
    var qqPaymentId = 'ruyeeQq01';
    var qqNotMaintain = 0;
    var bankAvailable = 1;
    var youBankAvailable = 1;
    var bankTradeMax = 49999.00;
    var wechatTradeMax = 1000;
    var alipayTradeMax = 20000;
    var qqTradeMax = 3000;

    var thirdPaymentUrl = 'http://www.csebet.org/index.ashx';
    var wechatPaymentUrl = 'http://www.csebet.org/index.ashx';
    var alipayPaymentUrl = '';
    var qqPaymentUrl = 'http://in.sythb.top/index.ashx';
    var thirdBankList = '';

    var bigalipayPaymentId = 'JmsAlipay';
    var bigalipayNotMaintain = 2;
    var bigalipayTradeMax = 20000;
    var bigalipayTradeMin = 500;

    var wechatTradeMin =  100;
    var alipayTradeMin = 100;
    if (alipayPaymentId == "zbpayAlipay01") {
        alipayTradeMin = 500;
    }
    var qqTradeMin = 100;
    /**
    * 实时动态强制更改用户录入
    **/
    function amount(th){
        var regStrs = [
            ['^0(\\d+)$', '$1'], //禁止录入整数部分两位以上，但首位为0
            ['[^\\d\\.]+$',''], //禁止录入任何非数字和点
            ['\\.(\\d?)\\.+', '.$1'], //禁止录入两个以上的点
            ['^(\\d+\\.\\d{2}).+', '$1'] //禁止录入小数点后两位以上
    
        ];
        for(var i=0; i<regStrs.length; i++){
            var reg = new RegExp(regStrs[i][0]);
            th.value = th.value.replace(reg, regStrs[i][1]);
        }
        $('.tk_num span').find('b').removeClass('on');
        if ($(th).val() < 100) {
            $("#depositMoney_tips").addClass("redtext");
        } else {
            $("#depositMoney_tips").removeClass("redtext");
        }
        
    }
    
    /**
    * 录入完成后，输入模式失去焦点后对录入进行判断并强制更改，并对小数点进行0补全
    **/
    function overFormat(th){
        var v = th.value;
        if(v === ''){
           // v = '0.00';
        }else if(v === '0'){
            v = '0.00';
        }else if(v === '0.'){
            v = '0.00';
        }else if(/^0+\d+\.?\d*.*$/.test(v)){
            v = v.replace(/^0+(\d+\.?\d*).*$/, '$1');
            v = inp.getRightPriceFormat(v).val;
        }else if(/^0\.\d$/.test(v)){
            v = v + '0';
        }else if(!/^\d+\.\d{2}$/.test(v)){
            if(/^\d+\.\d{2}.+/.test(v)){
                v = v.replace(/^(\d+\.\d{2}).*$/, '$1');
            }else if(/^\d+$/.test(v)){
                v = v + '.00';
            }else if(/^\d+\.$/.test(v)){
                v = v + '00';
            }else if(/^\d+\.\d$/.test(v)){
                v = v + '0';
            }else if(/^[^\d]+\d+\.?\d*$/.test(v)){
                v = v.replace(/^[^\d]+(\d+\.?\d*)$/, '$1');
            }else if(/\d+/.test(v)){
                v = v.replace(/^[^\d]*(\d+\.?\d*).*$/, '$1');
                ty = false;
            }else if(/^0+\d+\.?\d*$/.test(v)){
                v = v.replace(/^0+(\d+\.?\d*)$/, '$1');
                ty = false;
            }else{
                v = '0.00';
            }
        }
        th.value = v;
    }
</script>

<script src="/static/js/jquery-zclip-master/jquery.zclip.js"></script>
<script src="/static/js/deposit.js?201802221525"></script>
<script src="/static/js/jquery.pj.js"></script>