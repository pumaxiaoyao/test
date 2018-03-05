$(function () {
    startRefreshBalances();
    $("#refreshMainBt").click(function () {
        btRefreshBalances();
    });
})


function startRefreshBalances() {
    var partnerCodeArr = ["IBC", "NB"];

    for (var i = 0; i < partnerCodeArr.length; i++) {
        postBalances(partnerCodeArr[i]);
    }
}

function btRefreshBalances() {
    var partnerCodeArr = ["IBC", "NB"];

    for (var i = 0; i < partnerCodeArr.length; i++) {
        $("#" + partnerCodeArr[i] + "_balace").removeClass("gray");
        $("#" + partnerCodeArr[i] + "_balace").html('<img src="/static/img/loading.gif" />');
        postBalances(partnerCodeArr[i]);
    }
}

function postBalances(partnerCode) {
    $.post("/API/common/RefreshBalance", { partnerCode: partnerCode ,clienttype: 1}, function (response) {
        setBalance(response);
    });
}

function setBalance(response) {
    response = JSON.parse(response);
    console.log(response);

    if (response.code == 200) {
        var balance = parseFloat(response.amount).toFixed(2);
        console.log(balance);
        $("#" + response.GP + "_balace").html(balance);
    }else if (response.b) {
        $("#" + response.GP + "_balace").addClass("gray");
        $("#" + response.GP + "_balace").html("维护");
    }
    response = null;
}