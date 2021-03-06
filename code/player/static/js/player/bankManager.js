$(function () {
    // function getDistrictHTML(act, upid, name) {
    //     $.ajax({
    //         type: "POST",
    //         url: "/API/Ashx/District.ashx",
    //         data: "action=" + act + "&upid=" + upid + "&name=" + name,
    //         success: function (result) {
    //             if (act == "privince") {
    //                 $("#PrivinceDiv").html(result);
    //             } else if (act == "city") {
    //                 $("#CityDiv").html(result);
    //             } else if (act == "area") {
    //                 $("#AreaDiv").html(result);
    //             }
    //         }
    //     });
    // }

    // $("#Privince").val() == "" && getDistrictHTML("privince", 0, "");
    // $("body").on("change", "#Privince,#City,#Area", function (e) {
    //     var id = $(this).attr("id"), did = $(this).find("option:selected").attr("did");
    //     if (id == "Privince") {
    //         if (did == 0) { $("#City").find("option").slice(1).remove(); }
    //         else { getDistrictHTML("city", did, ""); }
    //         $("#Area").find("option").slice(1).remove();
    //         $("#provinceid").val(did); $("#cityid").val(0); $("#townid").val(0);
    //     }
    //     else if (id == "City") {
    //         if (did == 0) { $("#Area").find("option").slice(1).remove(); }
    //         else { getDistrictHTML("area", did, ""); }
    //         $("#cityid").val(did); $("#townid").val(0);
    //     }
    //     else if (id == "Area") {
    //         $("#townid").val(did);
    //     }
    // });


    $("#bindingBank").click(function () {
        $(".manage_box_one").hide();
        $(".manage_box_three").show();
    });

    $("#add_bank").click(function () {
        if ($(".manage_box_three").is(":hidden")) {
            $(".manage_box_three").slideDown();
        } else {
            $(".manage_box_three").slideUp();
        }
        
    });

    $("#addbank_bt").click(function () {
        var BankNo = $("#BankNo").val();
        var BankType = $("#BankType").val();
        var RealName = $("#RealName").val();
        var RegBank = $("#RegBank").val();
        // var Privince = $("#Privince").val();
        // var City = $("#City").val();
        // var Area = $("#Area").val();
        var code = $("#code_text").val();
        if (RealName == "") {
            swal({ title: "", text: "未绑定真实姓名", type: "warning" });
            return false;
        }

        if (BankNo == "") {
            swal({ title: "", text: "请输入银行卡号", type: "warning" });
            return false;
        }
        if (BankType == "") {
            swal({ title: "", text: "请选择开户银行", type: "warning" });
            return false;
        }
        if (RegBank == "") {
            swal({ title: "", text: "请选择开户地址", type: "warning" });
            return false;
        }
        // if (code == "") {
        //     swal({ title: "", text: "请输入验证码", type: "warning" });
        //     return false;
        // }
        if (isNaN(BankNo) || BankNo.length > 20 || BankNo.length < 10) {
            swal({ title: "", text: "请输入正确的银行卡号", type: "warning" });
            return false;
        }
        $.ajax({  
            type: "post",  
            url: '/player/addBankCard', 
            // 1 需要使用JSON.stringify 否则格式为 a=2&b=3&now=14...  
            // 2 需要强制类型转换，否则格式为 {"a":"2","b":"3"}  
            data: { BankNo: $.trim(BankNo), BankType: BankType, RealName: RealName,
                RegBank: RegBank, code: code },  
            contentType: "application/json; charset=utf-8",  
            dataType: "json",  
            success: function(recode) {
                var resp = recode.data;
                if (resp[0]) {
                    swal({ title: "", text: "您的银行卡绑定成功", type: "success" }, function () {
                        window.location.reload();
                    });
                } else  {
                    swal({ title: "", text: resp[1], type: "warning" });
                }}
        });  
    });

    $("#GetCodeBt").click(function () {

        $.post("/player/getBankCode", { action: 'sendcode' }, function (recode) {
            var resp = recode.data;
            if (resp[0]) {
                swal({ title: "", text: resp[1], type: "success" });
                $("#GetCodeBt").hide();
                $("#GetTime").show();
                interval = setInterval(function () { setRemainingTime() }, 1000);
            } else  {
                swal({ title: "", text: resp[1], type: "warning" });
            }
        }, "json");
    });
});

function delbank(thisv, id) {
    
    $.post("/player/delBankCard", { index: id }, function (recode) {
        var resp = recode.data;
        if (resp[0]) {
            $(thisv).parent().slideUp();
            swal({ title: "", text: "删除成功！", type: "success" });
        } else  {
            swal({ title: "", text: resp[1], type: "warning" });
        }
    }, "json");
}

var interval = null;
var timesec = 60;
function setRemainingTime() {
    timesec--;
    if (timesec < 0) {
        clearInterval(interval);
        interval = null;
        $("#GetCodeBt").show();
        $("#GetTime").hide();
        timesec = 60;
        $("#Timing").html(60);
        return;
    }

    $("#Timing").html(timesec);
}