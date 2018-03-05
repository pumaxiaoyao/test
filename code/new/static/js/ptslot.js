$(function () {
    addEvent();
    search();
});

function addEvent() {
    //点击游戏
    $("body").on("click", ".slots_top > ul > li > a, .slots_list > ul > li > a", function () {

        if (IsLogin != "True") {
            swal({ title: "", text: "请您先登录再进入游戏", type: "info" });
        } else {
            var code = $(this).attr("code");
            var url = "http://www.beplay.cc/productintegration/pt/login.aspx?game=" + code;
            window.open(url, "", "depended=yes,height=600,width=800");
        }

    });
    //添加收藏
    $("body").on("click", ".addtoFavorite", function () {
        if (IsLogin != "True") {
            swal({ title: "", text: "要登录才能收藏游戏哦", type: "info" });
        } else {
            var slotid = $(this).attr("slotid");
            if (!$(this).hasClass('on')) {
                $(this).addClass('on');
                $.post("http://www.beplay.cc/zh-cn/slot/Default.aspx", { action: 'favorite', slotid: slotid }, function (re) {
                    if (re != "200") {
                        swal({ title: "", text: re, type: "warning" });
                    }
                });
            } else {
                $(this).removeClass('on');
                $.post("http://www.beplay.cc/zh-cn/slot/Default.aspx", { action: 'delfavorite', slotid: slotid }, function (re) {
                    if (re != "200") {
                        swal({ title: "", text: re, type: "warning" });
                    }
                });
            }
        }
        return false;
    }); 
    $("#favoritelistbt").click(function () {
        $(this).addClass('on'); 
        $("#slots_tophot").hide();
        $("#slots_topfavoritet").show();
    });

    $("#tophotistbt").click(function () {
        $("#slots_topfavoritet").hide();
        $("#slots_tophot").show();
        $("#favoritelistbt").removeClass('on');
    });

    $("#search_gametype > span > a").click(function () {
        selectType(this);
        search();
    });
    $("[betSlt]").click(function () {
        selectBet(this);
        search();
    });
    $("[lineSlt]").click(function () {
        selectLine(this);
        search();
    });
    //style
    $("[disStyle]").click(function () {
        selectStyle(this);
        search();
    });
    //diffculty
    $("[diffType]").click(function () {
        selectDiff(this);
        search();
    });

}

//类别选择
function selectType(type) {
    var $this = $(type);
    $("#search_gametype > span > a").attr("typeSlt", 0);
    $("#search_gametype > span > a").removeClass("on");
    $this.attr("typeSlt", 1);
    $this.addClass("on");
}

//限额选择
function selectBet(bet) {
    var $this = $(bet);
    $("[betSlt]").attr("betSlt", 0);
    $("[betSlt]").removeClass("on");

    $this.attr("betSlt", 1);
    $this.addClass("on");
}

//线数选择
function selectLine(line) {
    var $this = $(line);
    $("[lineSlt]").attr("lineSlt", 0);
    $("[lineSlt]").removeClass("on");

    $this.attr("lineSlt", 1);
    $this.addClass("on");
}
//风格选择
function selectStyle(style) {
    var $this = $(style);
    if ($this.attr("disStyle") == "all") {
        $("[disStyle]").attr("styleSlt", 0);
        $("[disStyle]").removeClass("on");

        $("[disStyle='all']").attr("styleSlt", 1);
        $("[disStyle='all']").addClass("on");
    } else {
        $("[disStyle='all']").attr("styleSlt", 0);
        $("[disStyle='all']").removeClass("on");

        if ($this.attr("styleSlt") == 1) {
            $this.attr("styleSlt", 0);
            $this.removeClass("on");

            if ($("[styleSlt='1']").length == 0) {
                $("[disStyle='all']").attr("styleSlt", 1);
                $("[disStyle='all']").addClass("on");
            }
        } else {
            $this.attr("styleSlt", 1);
            $this.addClass("on");
        }
    }
}

//难度选择
function selectDiff(diff) {
    var $this = $(diff);
    $("[diffType]").attr("diffSlt", 0);
    $("[diffSlt]").removeClass("on");

    $this.attr("diffSlt", 1);
    $this.addClass("on");
}

//查找游戏
function search() {
    //筛选条件
    var data = {};

    if ($("[typeSlt='1']").attr("typeId") != 0) {
        data.TypeId = $("[typeSlt='1']").attr("typeId");
    }
    if ($("[betSlt='1']").attr("betValue") != 0) {
        data.BetLimit = $("[betSlt='1']").attr("betValue");
    }
    if ($("[lineSlt='1']").attr("lineValue") != 0) {
        data.LinesLimit = $("[lineSlt='1']").attr("lineValue");
    }
    if ($("[disStyle='all']").attr("styleSlt") == 0) {
        if ($("[disStyle='HD']").attr("styleSlt") != 0) {
            data.IsHD = $("[disStyle='HD']").attr("styleSlt");
        }
        if ($("[disStyle='movie']").attr("styleSlt") != 0) {
            data.IsMovie = $("[disStyle='movie']").attr("styleSlt");
        }
        if ($("[disStyle='anime']").attr("styleSlt") != 0) {
            data.IsAnime = $("[disStyle='anime']").attr("styleSlt");
        }
        if ($("[disStyle='girl']").attr("styleSlt") != 0) {
            data.IsGirl = $("[disStyle='girl']").attr("styleSlt");
        }
        if ($("[disStyle='other']").attr("styleSlt") != 0) {
            data.IsOther = $("[disStyle='other']").attr("styleSlt");
        }
    }
    if ($("[diffSlt='1']").attr("diffType") != 0) {
        if ($("[diffType='small']").attr("diffSlt") != 0) {
            data.IsSmall = $("[diffType='small']").attr("diffSlt");
        }
        if ($("[diffType='medium']").attr("diffSlt") != 0) {
            data.IsMedium = $("[diffType='medium']").attr("diffSlt");
        }
        if ($("[diffType='big']").attr("diffSlt") != 0) {
            data.IsBig = $("[diffType='big']").attr("diffSlt");
        }
    }


    $.ajax({
        type: "GET",
        url: "http://www.beplay.cc/zh-cn/slot/Default.aspx?action=search",
        dataType: "json",
        data: data,
        success: function (json) {
            createHtml(json);
        },
        error: function () { }
    });
}

//生成HTML
function createHtml(json) {
    var gameHtml = "";
    for (var i = 0; i < json.length; i++) {
        var game = json[i];
        gameHtml += '<li>';
        gameHtml += '	<a code="' + game.Code + '">';
        gameHtml += '		<div class="imgDiv">';
        gameHtml += '			<img src="/static/img/pt/' + game.Code + '.jpg" />';
        gameHtml += '		</div>';
        gameHtml += '		<div class="keywords">';
        gameHtml += game.g_auto;
        gameHtml += game.g_anime;
        gameHtml += game.g_girl;
        gameHtml += '		</div>';
        gameHtml += '		<div class="hot">';
        //gameHtml += '		<span class="' + game.g_movie + '"></span>';
        gameHtml += '		<span class="' + game.g_hd + '"></span>';
        gameHtml += '		</div>';
        gameHtml += '	    <div class="slots_covering">';
        gameHtml += '	    <b>' + game.NameCn + '</b>';
        gameHtml += '<span class="text_nr">最低赌注：' + game.BetLimit + '元<br />　　线数：' + game.LinesLimit + ' 线<br /></span><em><strong>立即游戏</strong><i slotid="' + game.Id + '" class="addtoFavorite ' + game.IsFav + '" ></i></em></div><span class="text">' + game.NameCn + '</span></a></li>';
    }
    $("#result").html(gameHtml);
}


