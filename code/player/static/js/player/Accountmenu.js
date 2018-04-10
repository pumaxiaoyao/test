$(function () {
    //初始化
    ampageinit();
    $("#refreshMainBt").click(function () {
        $("#MainBalance_b").html('<img src="/static/img/loading.gif" />');
        $.post("/common/RefreshBalance", { partnerCode: 'MAIN', clienttype: 4 }, function (response) {
            response = JSON.parse(response);
            var data = response.data;
            console.log(data);
            if (data[0]){
                var balance = parseFloat(data[2]).toFixed(2);
                $("#MainBalance_b").html(balance);
                $("#MainBalance_Nav").html(balance);
            }else{
                if (typeof response.im != "undefined" && response.im.length != 0) {
                    $("#MainBalance_b").html('维护');
                }    
            }
        });
    });
    $("#refreshAgentBt").click(function () {
        $("#MainBalance_b").html('<img src="/static/img/loading.gif" />');
        $.post("/agent/RefreshBalance", { partnerCode: 'MAIN', clienttype: 4 }, function (response) {
            response = JSON.parse(response);
            var data = response.data;
            console.log(data);
            if (data[0]){
                var balance = parseFloat(data[1]).toFixed(2);
                $("#MainBalance_b").html(balance);
                $("#MainBalance_Nav").html(balance);
            }else{
                if (typeof response.im != "undefined" && response.im.length != 0) {
                    $("#MainBalance_b").html('维护');
                }    
            }
        });
    });
});
function ampageinit() {
    var now = new Date();
    var times = now.getHours();
    var whe = parseInt(times);
    var timestr = "";
    var regardstr = ""
    if (times >= 0 && times < 6) { timestr = "夜深了"; regardstr = "寂静的夜空也无法阻挡您对自由的向往"; }
    if (times >= 6 && times < 7) { timestr = "天亮了"; regardstr = "好好呼吸一下早晨的新鲜空气吧"; }
    if (times >= 7 && times < 9) { timestr = "早上好"; regardstr = "早餐一定要丰盛，多吃点水果哦"; }
    if (times >= 9 && times < 12) { timestr = "上午好"; regardstr = "点根香烟喝杯茶，让大脑放松一下"; }
    if (times >= 12 && times < 13) { timestr = "中午好"; regardstr = "吃顿丰盛的午餐，为身体加加油"; }
    if (times >= 13 && times < 18) {
        timestr = "下午好";
        if (times >= 13 && times < 14) {
            regardstr = "睡个午觉补个眠，精神抖擞一整天";
        } else if (times >= 14 && times < 16) {
            regardstr = "来一杯清茶，提提神吧";
        } else if (times >= 16 && times < 18) {
            regardstr = "再忙也要起来走一走，抖擞精神";
        }
    }
    if (times >= 18 && times < 24)
    {
        timestr = "晚上好";
        if (times >= 18 && times < 20) {
            regardstr = "忙碌了一整天，晚餐吃顿好的吧";
        } else if (times >= 20 && times < 22) {
            regardstr = "来beplay娱乐城看看荷官，养养眼吧";
        } else if (times >= 22 && times < 24) {
            regardstr = "看球时间别忘了来beplay体育投两把";
        }
        
    } 
    $("#salutationtext").html(timestr + "，");
    $(".nr_nav_user_time").html(regardstr);
}
function Get_Greetings() {
    
}
