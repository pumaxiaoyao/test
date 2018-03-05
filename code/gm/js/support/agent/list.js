var aid = 0;
var aname = null;
var astatus = null;
var agroupid = 0;

$(document).ready(function () {
    $("#s_search").search({
        "_fnCallback": function (resp) {
            $("#total").text(resp.iTotalRecords);
            bind_remark_btn();
            $('label[remark=remark]').tooltip();
        }
    });
});

/****代理备注*****/
var _aid;
function bind_remark_btn(){
    $('a[remark=remark]').on('click',function(){
        _aid = $(this).attr('aid');
        $('#remark').val($(this).prev().attr('data-original-title'));
        $('#remarkModal').modal();
    });
}

function saveRemark(){
    var remark = $('#remark').val();
    $.post('/agent/saveRemark',{aid:_aid,remark:remark},function(data){
        data = JSON.parse(data);
        if(data.code == 200){
            $('#remark_'+_aid).text(remark).attr('data-original-title',remark).tooltip();
            $('#remarkModal').modal('hide');
            $.notific8('备注代理成功！');
        }else{
            $.notific8('备注代理失败！', {theme: 'ebony'});
        }
    });
}

function lockunlock(o) {

    aid = $(o).attr("aid");
    aname = $(o).attr("aname");
    astatus = $(o).attr("astatus");

    if ($(o).text() == "锁定") {
        // 停用账户
        $("#accountModal").find("#title").text("锁定账户");
        $("#accountModal").find("#info").text("确定锁定账户“" + aname + "”？");
    } else {
        // 启用账户
        $("#accountModal").find("#title").text("解锁账户");
        $("#accountModal").find("#info").text("确定解锁账户“" + aname + "”？");
    }
}

// 提交啟用/停用
$("#accountModal #save").click(function () {
    $.ajax({
        type: "post",
        url: "/agent/lockAgent",
        data: {aid:aid, status:astatus},
        error:function(){
            $.notific8("未知错误，请联系管理员！", {theme: 'ebony'});
        },
        success: function (d) {
            d = JSON.parse(d);
            if (d.code == 200) {
                $.notific8("修改成功!");
                $("#accountModal").find("button:first").click();
                target[1].fnReloadAjax();
            } else {
                $.notific8(data.Message, {theme: 'ebony'});
            }
        }
    });
});

$("#editModal #btn_save").click(function(){
    var aid = $('#editModal').find("#aid").val();
    var aname = $('#editModal').find("#realname").val();
    var aemail = $('#editModal').find("#email").val();
    var aphone = $('#editModal').find("#mobile").val();
    var aqq = $('#editModal').find("#qq").val();
    $.ajax({
        type: "post",
        url: "/agent/saveAgentInfo",
        data: {aid:aid, name: aname, email:aemail, phone:aphone, qq:aqq},
        error:function(){
            $.notific8("未知错误，请联系管理员！", {theme: 'ebony'});
        },
        success: function (d) {
            d = JSON.parse(d);
            if (d.code == 200) {
                $.notific8("修改成功!");
                $('#editModal').find(".close[data-dismiss=modal]").click();
                target[1].fnReloadAjax();
            } else {
                $.notific8(data.Message, {theme: 'ebony'});
            }
        }
    });

});

// 保存更改層級信息
$("#levelModal #save").click(function () {

    var layerid = $("input[name='layerid']:checked").val();
    console.log(layerid);
    $.ajax({
        type: "post",
        url: "/agent/changeLayer",
        data: {aid:aid, layerid:layerid},
        error:function(){
            $.notific8("未知错误，请联系管理员！", {theme: 'ebony'});
        },
        success: function (d) {
            d = JSON.parse(d);
            if (d.code == 200) {
                $.notific8("修改成功!");
                // $('#editModal').find(".close[data-dismiss=modal]").click();
                $("#levelModal").find("button:first").click();
                target[1].fnReloadAjax();
            } else {
                $.notific8(data.Message, {theme: 'ebony'});
            }
        }
    });
});


function getLayerList(o) {
    aid = $(o).attr("aid");
    layerid = $(o).attr("layerid");

    $.getJSON("/agent/getLayerList", function (rep) {
        var html = "";
        var ret = rep.data;
        for (var i = 0; i < ret.length; i++) {
            var d = ret[i];

            html += '<tr>';
            html += '<td>';
            html += '<label><input type="radio" ';
            if (layerid == d.layerid) {
                html += "checked";
            }
            html += ' name="layerid" value="' + d.layerid + '" ></label>';
            html += '</td>';
            html += '<td>' + d.name + '</td>';
            html += '<td>' + d.note + '</td>';
            html += '<td>' + d.isAllocation + '</td>';
            html += '<td>' + d.isCommision + '</td>';
            html += '<td>' + d.isWater + '</td>';
            html += '</tr>';
        }
        $("#groupList").html(html);
    });
}

