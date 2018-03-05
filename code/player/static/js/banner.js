//广告图: 

var cnhomeResponse = { "errcode": 0, "errmsg": "", "width": 1920, "height": 460, "max_size": 9, "has_icon": true, "imgs": [{ "id": "img201510111777226", "name": "1", "src": "/att/expand/imgs/201510121646181.jpg", "has_btn": true, "icon": { "src": "/att/expand/imgs/201510121632019.png" }, "button": { "txt": "进入游戏", "href": "betsoft/Default.aspx" } }, { "id": "img201510111821263", "name": "2", "src": "/att/expand/imgs/201510121675425.jpg", "has_btn": false, "icon": { "src": "/att/expand/imgs/201510121654247.png" }, "button": null }, { "id": "img201510131897424", "name": "3", "src": "/att/expand/imgs/201510131853779.jpg", "has_btn": true, "icon": { "src": "/att/expand/imgs/201510131819435.png" }, "button": { "txt": "球队赞助", "href": "help/index.aspx?a=banner" } }, { "id": "img201510131858955", "name": "4", "src": "/att/expand/imgs/201510131894671.jpg", "has_btn": false, "icon": { "src": "/att/expand/imgs/201510131846202.png" }, "button": null }, { "id": "img201510131812031", "name": "5", "src": "/att/expand/imgs/201510131801018.jpg", "has_btn": true, "icon": { "src": "/att/expand/imgs/201510131805019.png" }, "button": { "txt": "活动详情", "href": "promotions/promotions.aspx" } }, { "id": "img201510131852568", "name": "6", "src": "/att/expand/imgs/201510131878674.jpg", "has_btn": false, "icon": { "src": "/att/expand/imgs/201510131876105.png" }, "button": null }, { "id": "img201510131842341", "name": "7", "src": "/att/expand/imgs/201510131852718.jpg", "has_btn": false, "icon": { "src": "/att/expand/imgs/201510131890629.png" }, "button": null }, { "id": "img201510131822919", "name": "8", "src": "/att/expand/imgs/201510131880541.jpg", "has_btn": true, "icon": { "src": "/att/expand/imgs/201510131854747.png" }, "button": { "txt": "进入游戏", "href": "keno/Default.aspx" } }] }
$(function () { HomeBanner.Run(cnhomeResponse); });

//首页
var HomeBanner = function () {
    return {
        Run: function (response) {
            banner.secound = 300;
            banner.init(response.imgs);
            banner.createKnob();
            banner.timeout = setInterval(function () {
                banner.timing();
            }, banner.secound);
        }
    };
}();


var banner = {
    "baseUri": "",
    "size": 6,
    "timeout": null,
    "secound": 100,
    "secondTime": 0,
    "maxSecond": 100,
    //"dateStamp": "100112",
    "init": function (bannerList, options) {
        this.size = bannerList.length;

        var $this = this;
        for (var i = 0; i < $this.size; i++) {
            var isShow = i == 0 ? 1 : 0;
            var cssstr = i == 0 ? "on" : "";
            var stylestr = i == 0 ? "opacity:1;  filter:alpha(opacity=100); " : "";

            var imgstr = "<div class='gt_img' showindex='" + (i + 1)
                       + "' style='background:url(" + $this.baseUri + bannerList[i]["src"] + ") no-repeat center;"
                       + stylestr
                       + "'></div>";

            //图片
            $(".gt_binner").append(imgstr);

            if (bannerList[i]["icon"] != null) {
                var ctrlstr = "<div class='gt_icon " + cssstr + "' onCtrl='" + isShow + "' ctrlindex='" + (i + 1)
                        + "' style='background:url(" + $this.baseUri + bannerList[i]["icon"]["src"] + ") no-repeat;'>"
                        + "<input type='text' id='kb" + (i + 1) + "' class='ctc_btn'/></div>";
                //圆形缩略图
                $(".gt_bnctrl").append(ctrlstr);
            }

            if (bannerList[i]["button"] != null) {
                var btnstr = "<div class='gt_ad_btn4' for_index='" + (i + 1) + "' style='display: "+ (i == 0 ? "block" : "none") +";'>"
                           + "<a class='dl_btn' href='" + bannerList[i]["button"]["href"] + "'>" + bannerList[i]["button"]["txt"] + "</a>"
                           + "</div>";
                //链接按钮
                $(".gt_swf").append(btnstr);
            }
        }

        $(".gt_icon").unbind().click(function () {
            var nextId = $(this).attr("ctrlindex");
            banner.clickChange(nextId);
        });
    },
    "changeImg": function (nextId) {
        var $this = this;
        if ($this.timeout != null) {
            clearInterval($this.timeout);
            $this.timeout = null;
        }

        var currentId = $("[onctrl='1']").attr("ctrlindex");
        //change pointer
        $("[ctrlindex='" + currentId + "']").removeClass("on");
        $("[ctrlindex='" + nextId + "']").addClass("on");
        $("[ctrlindex='" + currentId + "']").attr("onctrl", "0");
        $("[ctrlindex='" + nextId + "']").attr("onctrl", "1");

        //隐藏按钮
        $("[for_index]").css({ "display": "none" });
        //隐藏按钮 end
        //change background
        $("[showindex='" + currentId + "']").stop(true, false).animate({ "opacity": 0 }, 700, "easeOutCubic", function () {
            //显示按钮
            $("[for_index]").each(function (index, element) {
                var imgIndex = $(element).attr("for_index");
                if (imgIndex == nextId) {
                    $(element).css({ "display": "block" });
                }
            });
            //显示按钮end
        });
        $("[showindex='" + nextId + "']").stop(true, false).animate({ "opacity": 1 }, 700, "easeOutCubic", function () {

        });
        $this.timeout = setInterval(function () {
            $this.timing();
        }, $this.secound);
    },
    "nextBackground": function () {
        var $this = this;
        var currentId = $("[onctrl='1']").attr("ctrlindex");
        currentId = parseInt(currentId, 10);
        var next = currentId % $this.size + 1;
        $this.changeImg(next);
    },
    "createKnob": function () {
        var $this = this;
        for (var i = 1; i <= $this.size; i++) {
            $("#kb" + i).knob({
                "width": 40,
                'min': 0,
                'max': $this.maxSecond,
                "displayInput": false,
                "displayPrevious": true,
                "thickness": ".1",
                "fgColor": "#3cd2f5",
                "bgColor": "none",
                "readOnly": true
            });
        }

    },
    "timing": function () {
        var $this = this;
        var showIndex = $("[onctrl='1']").attr("ctrlindex");
        showIndex = parseInt(showIndex, 10);
        var next;
        next = showIndex % $this.size + 1;

        if ($this.secondTime == $this.maxSecond) {
            $this.secondTime = 0;
            $("#kb" + showIndex).val(0).trigger('change');
            //changeImg("right");
            $this.changeImg(next);
        } else {
            $this.setKnobValue("kb" + showIndex);
        }
    },
    "clickChange": function (next) {
        var $this = this;
        var showIndex = $("[onctrl='1']").attr("ctrlindex");
        $this.secondTime = 0;
        $("#kb" + showIndex).val(0).trigger('change');
        $this.changeImg(next);
    },
    "setKnobValue": function (id) {
        var $this = this;
        $("#" + id).val($this.secondTime).trigger('change');
        $this.secondTime++;
    }
}
