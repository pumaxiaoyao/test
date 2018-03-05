var showPlay = false;
var Index = function () {
    //进度显示效果
    var runAnimateProgressbar = function () {
        $('.progress .progress-bar').each(function (i, obj) {
            $(this).attr('data-transitiongoal', $(this).attr('data-transitiongoal-backup'));
            $(this).progressbar();
        });
        $('.progress .progress-bar').progressbar();
    };
    //数字滚动
    var scrollNumber = function () {
        /* target = 目标元素的 ID；
           startVal = 开始值；
           endVal = 结束值；
           decimals = 小数位数，默认值是0；
           duration = 动画延迟秒数，默认值是2；*/

        var options = {
            useEasing: true,
            useGrouping: false,
            separator: ',',
            decimal: '.',
            prefix: '',
            suffix: ''
        };
        var deposit_num = new CountUp("deposit_num", 0, 56, 0, 2.5, options);
        deposit_num.start();

        var take_num = new CountUp("take_num", 0, 3, 0, 2.5, options);
        take_num.start();

        var deposit_num2 = new CountUp("take_num_s", 0, 48, 0, 2, options);
        deposit_num2.start();
    };
    //存款时间和取款时间
    var scrollDepositAndWithdrawTime = function () {
        $(window).scroll(function () {
            var showPosition = $(window).height() + $(window).scrollTop();
            if (showPosition > 1000 && !showPlay) {
                scrollNumber();
                runAnimateProgressbar();
                showPlay = true;
            }
        });
    };
    //新闻水平滚动
    var migrateNotice = function () {
        $('.marquee').marquee({
            //speed in milliseconds of the marquee
            duration: 6000,
            //gap in pixels between the tickers
            gap: 50,
            //time in milliseconds before the marquee will start animating
            delayBeforeStart: 0,
            //'left' or 'right'
            direction: 'left',
            //true or false - should the marquee be duplicated to show an effect of continues flow
            duplicated: true
        });
    }
    var animateIphoneImg = function () {
        $("#iphone-img").animate({          
            opacity: 1,
            top: 0
        });
    };
    return {
        init: function () {
            //runAnimateProgressbar();
            scrollDepositAndWithdrawTime();
            migrateNotice();
            animateIphoneImg();
        }
    };
}();

//公告
function showAnnMessage() {
    $("#ann_box").show();
}

function hideAnnMessage() {
    $("#ann_box").hide();
}

$(function () {
    //iframe 加载事件 站内信
    var iframe = $("#msgIframe")[0];
    if (iframe != null) {
        if (iframe.attachEvent) {
            iframe.attachEvent("onload", function () {
                //以下操作必须在iframe加载完后才可进行  
                $("#popLoading").css({ "display": "none" });
            });
        } else {
            iframe.onload = function () {
                //以下操作必须在iframe加载完后才可进行  
                $("#popLoading").css({ "display": "none" });
            };
        }
    }

});

