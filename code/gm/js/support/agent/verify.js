var nowid = 0;

$(document).ready(function () {

    $("#s_search").search({
        "_fnCallback": function (resp) {
            $("#total").text(resp.iTotalRecords);
            bind_remark_btn();
        }
    });

    // 搜索按鈕事件
    $("#submitAgent").click(function () {
        $("#searchAgent").submit();
    });

    // 点击通过
    $("#checkAgentModal #agentPass").click(function () {
        var remark = getVerifyRemark();
        if (remark == '') {
            remark = '客服通过';
        }
        submitCheckinfo("1", remark);
    });

    // 点击拒绝
    $("#checkAgentModal #agentReject").click(function () {
        var remark = getVerifyRemark();
        if (remark == '') {
            remark = '客服拒绝';
        }
        submitCheckinfo("2", remark);
    });

});

function getVerifyRemark() {
    var remark = $('#vremark').val();
    var reg = /^\s*$/i;
    return reg.test(remark) ? '' : remark;
}


/****代理备注*****/
var _aid;

function bind_remark_btn() {
    $('a[remark=remark]').on('click', function () {
        _aid = $(this).attr('aid');
        $('#remark').val($(this).prev().attr('data-original-title'));
        $('#remarkModal').modal();
    });
}

function saveRemark() {
    var remark = $('#remark').val();
    $.post('/agent/saveRemark', {
        aid: _aid,
        remark: remark
    }, function (data) {
        if (data.success) {
            $('#remark_' + _aid).text(data.response.remark).attr('data-original-title', remark).tooltip();
            $('#remarkModal').modal('hide');
            $.notific8('备注代理成功！');
        } else {
            $.notific8('备注代理失败！', {
                theme: 'ebony'
            });
        }
    });
}
/****代理备注结束*****/


function setInfo(agentname, aganeid) {
    $("#AgentLayerSelectData").attr("agentid", aganeid);
    $.ajax({
        type: "post",
        url: "/settings/getAgentLayer",
        success: function (data) {
            data = JSON.parse(data);
            var layerdata = data.data;
            var seleObj = '<select id="AgentLayerData" class="form-control" name="AgentLayerData"><option value="0">&nbsp;</option>';

            for (index in layerdata) {
                var item = layerdata[index];
                seleObj += '<option value="'+ item.id+'">' + item.name+ '</option>';
                // if (index == 0) {
                //     seleObj += '<option selected value="'+ item.id+'">' + item.name+ '</option>';
                // } else {
                //     seleObj += '<option value="'+ item.id+'">' + item.name+ '</option>';
                // }
            }
            seleObj += "</select>";
            $("#AgentLayerSelectData").html(seleObj);
        }
    });
}

function submitCheckinfo(status, remark) {
    var agentid = $("#AgentLayerSelectData").attr("agentid");
    var layerid = $("#AgentLayerData").val();

    $.ajax({
        type: "post",
        dataType: "json",
        url: "/agent/agentVerify?r=" + Math.random(),
        data: {
            agentid: agentid,
            layerid: layerid,
            note: remark,
            status: status
        },
        success: function (resp) {
            if (resp.code == 200) {
                $.notific8("审核结果提交成功");
                $(".close[data-dismiss=modal]").click();
                target[1].fnReloadAjax();
            } else {
                $.notific8(resp.Message, {
                    theme: 'ebony'
                });
            }
        },
        error: function (err) {
            $.notific8(err, {
                theme: 'ebony'
            });
        }
    });
}