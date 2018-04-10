var nowbcid = 0;


$(function () {
    $('#frmaddbankcard').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: "", // validate all fields including form hidden input
        rules: {
            bowner: {
                realname: true,
                required: true
            }, cardnum: {
                required: true
            }, bankaddr: {
                required: true
            },
            dealsrate: {
                min: 0,
                number: true
            },
            balancelimit: {
                required: true,
                number: true,
                min: 0,
                max: 1000000000000
            }, remark: {
                required: true
            }
        }
    });
});

function reset() {
    $('#frmaddbankcard').find('i.fa-warning').removeClass('fa-warning');
    $('#frmaddbankcard').find('div.has-error').removeClass('has-error');
    $('#frmaddbankcard').find('i.fa-check').removeClass('fa-check');
    $('#frmaddbankcard').find('div.has-success').removeClass('has-success');
}

//添加银行卡&&编辑银行卡
$("#btnaddcard").click(function () {
    var flag = $('#frmaddbankcard').valid();
    if (flag) {
        var data = $("#frmaddbankcard").serialize();
        var url = nowbcid == 0 ? "/kzb/bank/addcard" : "/kzb/bank/editcard"
        if (nowbcid != 0) {
            data += "&bcid=" + nowbcid;
        }
        data += "&bcweight=0";
        $.ajax({
            url: url,
            type: 'post',
            data: data,
            success: function (data) {
                if (data.c == 0) {
                    $.notific8("操作成功");
                    window.location.reload();
                } else {
                    $.notific8(errorMsg(data), {theme: 'ebony'});
                }
            },
            cache: false
        });
    }

});
//绑定三方支付
$("#btnbindmc").click(function () {
    var _t = $("#mclist").val().split("-");
    var accountid = _t[0];
    var ppid = _t[1];
    var bcid = nowbcid;
    var data = "accountid=" + accountid + "&ppid=" + ppid + "&bcid=" + bcid;
    $.ajax({
        url: '/kzb/bank/bindmerch',
        type: 'post',
        data: data,
        success: function (data) {
            if (data.c == 0) {
                $.notific8("绑定成功");
                window.location.reload();
            } else {
                $.notific8(errorMsg(data), {theme: 'ebony'});
            }
        },
        cache: false
    });
});
function bindid(id) {
    nowbcid = id;
}

function editbc(id) {
    reset();
    $("#bdict").attr("disabled", true);
    $("div[hidefor=ststus]").show();
    nowbcid = id;
    $("#title").text("编辑银行卡");
    $("#frmaddbankcard").find("input").val("");
    $.getJSON("/bank/getCardInfo?id=" + id, function (data) {
        $.each(data[0], function (i, item) {
            var key = i;
            if ($("#" + key).length > 0)$("#" + key).val(item);
            //if(key=="bcid"){$("#bdict").find("option[value="+item+"]").attr("selected");}
        });
    });
}

function addbc() {
    reset();
    $("#bdict").attr("disabled", false);
    nowbcid = 0;
    $("#frmaddbankcard").find("input").val("");
    $("#title").text("新增银行卡");
}
//解除三方支付绑定
function unbindid(bcid) {
    $.ajax({
        url: '/kzb/bank/unbindmerch',
        type: 'post',
        data: "bcid=" + bcid,
        success: function (data) {
            if (data.c == 0) {
                $.notific8("解除绑定成功");
                window.location.reload();
            } else {
                $.notific8(errorMsg(data), {theme: 'ebony'});
            }
        },
        cache: false
    });
}

$(function () {
    $('#bank_list').on('click', function () {
        $('#bankListModal').modal();
    });
});

function editBank(obj, id) {
    $('#bank_id').val(id);
    $('#bank_order').val($('#order_' + id).text());
    $('#bank_name').val(obj.getAttribute('bankname'));
    $('#bankEditModal').modal();
}

function saveBank() {
    var id = $('#bank_id').val();
    var order = $('#bank_order').val();
    $.post('/bank/editBank', {id: id, order: order}, function (data) {
        if (data.success) {
            $.notific8(data.msg);
            $('#order_' + id).text(order);
            $('#bankEditModal').modal('hide');
        } else {
            $.notific8(data.msg, {theme: 'ebony'});
        }
    });
}