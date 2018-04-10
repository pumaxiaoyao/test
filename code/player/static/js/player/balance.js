$(function () {
    //partnerCodeArr 由前置脚本从php赋值初始化
    startRefreshBalances();
    $("#refreshMainBt").click(function () {
        btRefreshBalances();
    });
})


function startRefreshBalances() {
    for (var i = 0; i < partnerCodeArr.length; i++) {
        postBalances(partnerCodeArr[i]);
    }
}

function btRefreshBalances() {
    for (var i = 0; i < partnerCodeArr.length; i++) {
        $("#" + partnerCodeArr[i] + "_balace").removeClass("gray");
        $("#" + partnerCodeArr[i] + "_balace").html('<img src="/static/img/loading.gif" />');
        postBalances(partnerCodeArr[i]);
    }
}

function postBalances(partnerCode) {
    $.post("/common/RefreshBalance", { partnerCode: partnerCode ,clienttype: 1}, function (response) {
        setBalance(response);
    });
}

function setBalance(response) {
    response = JSON.parse(response);
    var data = response.data;

    if (data[0]) {
        var balance = parseFloat(data[2]).toFixed(2);
        var GP = data[3];
        console.log(balance);
        $("#" + GP + "_balace").removeClass("gray");
        $("#" + GP + "_balace").addClass("blue");
        $("#" + GP + "_balace").html(balance);
    } else if (data[1] == "maintain") {
        var GP = data[3];
        $("#" + GP + "_balace").addClass("gray");
        $("#" + GP + "_balace").html("维护");
    } else {
        var GP = data[3];
        $("#" + GP + "_balace").addClass("gray");
        $("#" + GP + "_balace").html("NA");
    }
    response = null;
}