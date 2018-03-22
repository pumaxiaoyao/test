/**
 *
 * 玩家踢线
 */
var _now_uid = 0;

$(function () {
    $("#atype1").change(function () {
        if ($("#atype1").val() == "1") {
            $("#bcidIn").removeClass("hide");
            $("#bcidOut").addClass("hide");
            $('#bcidIn').change();
        } else {
            $("#bcidOut").removeClass("hide");
            $("#bcidIn").addClass("hide");
            $('#showLimit').hide();
        }
    });


    $("input[id^=j],select[id^=j]").change(function () {
        var id = $(this).attr("id").replace("jb", "").replace("ja", "").replace("jz", "").replace("jj", "").replace("jv", "");
        if (id == 1) {
            if ($("#atype" + id).val() == 1) {
                $("#bcidIn").removeClass("hide");
                $("#bcidOut").addClass("hide");
            } else {
                $("#bcidOut").removeClass("hide");
                $("#bcidIn").addClass("hide");
            }
        }
        var a = getnum("#ja" + id);
        var b = getnum("#jb" + id);
        var jl = a.times(b);
        var jz = getnum("#jz" + id);
        var v = $("#jj" + id).val() == "1" ? jl.plus(jz) : jl.minus(jz);

        $("#jc" + id).val(jl);
        $("#jv" + id).val(v);
    });


    $('#cardId').change(function () {
        var option = $(this).find('option:selected');
        init_balance(option.attr('balance'), option.attr('limit'));
    });


    $('#ja1').change(function () {
        var option = $('#cardId').find('option:selected');
        init_balance(option.attr('balance'), option.attr('limit'))
    });

});

function getnum(o) {
    var v = $(o).val();
    if (v == "")v = 0;
    if (isNaN(v))v = 0;
    return new BigNumber(v);
}
var doAdjBon = false;
function SaveConfig(t, o) {
    if (doAdjBon == true) {
        return false;
    }
    $.blockUI({css: {'z-index': 20000}});
    doAdjBon = true;
    var url = t == 1 ? "/kzb/fund/adjust" : "/kzb/fund/bouns", data;

    var atype = $("#atype" + t).val();
    var remark = $("#remark" + t).val();
    var amount = $("#ja" + t).val();
    var flows = $("#jv" + t).val();
    var gpid = $("#gpid" + t).val();
    var actid = t == 1 ? "" : $("#actid" + t).val();
    data = {atype: atype, uid: _now_uid, remark: remark, amount: amount, flows: flows, gpid: gpid, actid: actid};
    if (t == 1) {
        data.bcid = $('#cardId').val();
    }

    if (remark == "") {
        doAdjBon = false;
        $.unblockUI();
        $.notific8("请填写备注信息", {theme: 'ebony'});
        return false;
    }

    $.ajax({
        url: url,
        type: 'post',
        data: data,
        success: function (data) {
            data = JSON.parse(data);
            doAdjBon = false;
            if (data.c == 0) {
                $.notific8("成功");
                $(o).next().click();
                $("#s_submit").click();
                $.unblockUI();
            } else {
                $.unblockUI();
                $.notific8(errorMsg(data), {theme: 'ebony'});
            }
        },
        error: function (e) {
            doAdjBon = false;
            $.unblockUI();
        },
        cache: false
    });
}

function playerkickdown(id) {
    art.dialog({
        content: '确定要踢玩家下线吗？',
        lock: true,
        ok: function () {
            $.get("/player/kickdown?id=" + id, function (data) {
                art.dialog({
                    time: 1,
                    icon: 'succeed',
                    content: data['msg'],
                    lock: true
                });
                $("#s_search").submit();
            });
        },
        cancelVal: '关闭',
        cancel: true
        // 为true等价于function(){}
    });

}

/**
 *
 * 封IP
 */
function lockPlayerIp(id) {
    // jQuery ajax
    var dialog = art.dialog({
        id: 'N3690',
        title: false
    });
    $.ajax({
        url: '/player/editLockIp?id=' + id,
        success: function (data) {
            dialog.content(data);
            $("#s_search").submit();
        },
        cache: false
    });

}

/**
 *
 * 玩家校验
 */
function checkPlayer(id) {
    art.dialog({
        content: '确定要校验了吗？',
        lock: true,

        button: [
            {
                name: '通过',
                callback: callCheckPlayer(id, 1),
            },
            {
                name: '不通过',
                callback: callCheckPlayer(id, 2)
            },

            {
                name: '关闭'
            }
        ]
        // 为true等价于function(){}
    });
}

function playerLog(){
    
}

function callCheckPlayer(id, datastatus) {
    return function () {
        $.get("/player/checkPlayer?id=" + id + "&datastatus=" + datastatus, function (data) {
            art.dialog.tips(data['msg']);
            //	window.location.reload();
            $("#s_search").submit();
        });
    };
}
/**
 *
 * 玩家锁定
 */
// function lockPlayer(o, id) {
//     var key = $(o).text();
//     var url = "/player/lockPlayer";
//     var f = "解锁";
//     var action = "lock";
//     var fcolor = "red";
//     var color = "green";
//     if (key == "解锁") {
//         url = "/player/lockPlayer";
//         action = "unlock";
//         f = "锁定";
//         fcolor = "green";
//         color = "red";
//     }

//     art.dialog({
//         content: '确定要' + key + '该用户吗？',
//         lock: true,

//         button: [
//             {
//                 name: key,
//                 callback: function () {
//                     $.ajax({
//                         type: 'POST',
//                         url: url,
//                         data: {playerid: id, action: action},
//                         success: function (data) {
//                             if (data.code == 200) {
//                                 $.notific8("已" + key);
//                                 //$("#s_submit").click();
//                                 if (key == "解锁") {
//                                     $(o).text("锁定");
//                                     $(o).parent().prev().text("正常");
//                                     $(o).removeClass("green").addClass("red");
//                                 }else{
//                                     $(o).text("解锁");
//                                     $(o).parent().prev().text("锁定");
//                                     $(o).removeClass("red").addClass("green");
//                                 }
//                             } else {
//                                 $.notific8(errorMsg(data.Message), {theme: 'ebony'});
//                             }
//                         },
//                         error: function (XMLHttpRequest, textStatus, errorThrown) {
//                             if (XMLHttpRequest.status == 403) {
//                                 top.window.location.href = "/account/login";
//                             }
//                         },
//                         dataType: "JSON"
//                     });
//                 },
//             },
//             {
//                 name: '取消'
//             }
//         ]
//     });
// }


function test() {

    art.dialog.open('/player/editPlayerGroup', {title: '手工添加银行对账记录', width: "60%", top: "70%", height: "75%"});
}

/**
 * 调整玩家组list
 *
 */
function changePlayerGroup(playerid) {
    art.dialog.open('/player/editPlayerGroup?id=' + playerid,
        {
            title: '调整层级', width: "60%", top: "70%",
            close: function () {
                $("form").first().submit();
            }
        });

}

/**
 * 操作玩家组
 */
function changePlayerGroupOpt(obj) {
    var objArr = obj.split(",");
    if (objArr[1] != 0) {
        art.dialog.tips("该层级已启用!");
        return;
    }
    var playerid = $("#playerid").val();
    $.get("/player/changePlayerGroupOpt?groupid=" + objArr[0] + "&playerid=" + playerid, function (data) {
        art.dialog.tips(data['msg']);
        $("form").first().submit();
    });
}

/**
 * 修改玩家信息
 */
function editPlayerDetail(id) {
    window.location.href = "/player/playerDetail?id=" + id;
}

function saveplayerdetail(id) {
    //var postdata = $("#playerdetail").serialize() + "&playerid=" + id + "&stateabbr=cn";
    console.log(id);
    var realname = $('#realname').val();
    var email = $('#email').val();
    var mobile = $('#mobile').val();
    var qq = $('#qq').val();
    var birthday = $('#birthday').val();
    $.ajax({
        url: '/player/editProf',
        type: 'post',
        data: {realname:realname,email:email,mobile:mobile,qq:qq,birthday:birthday,uid:id},
        success: function (data) {
            data = JSON.parse(data);
            if (data.code == 200) {
                $.notific8(data.Message);
                //history.go(-1);
            }
            else {
                $.notific8(data.Message, {theme: 'ebony'});
            }
        },
        cache: false
    });
}

var wd_status = {1:{name:'无效',btn:'设为有效'},2:{name:'有效',btn:'设为无效'}}
$(function(){
    $('a[valid=valid]').on('click',function(){
        var wdbankid = $(this).attr('wdbankid');
        var obj = this;
        var status = $(this).attr('status');
        $.post('/player/editWithdrawCard',{wdbankid:wdbankid,status:status},function(data){
            if(data.success){
                $(obj).attr('status',data.response.status);
                $(obj).text(wd_status[status].btn);
                if(status == 1){
                    $(obj).addClass('green').removeClass('red');
                    $(obj).parent().prev().html('<span class="label label-danger">'+wd_status[status].name+'</span>');
                }else{
                    $(obj).addClass('red').removeClass('green');
                    $(obj).parent().prev().html('<span class="label label-success">'+wd_status[status].name+'</span>');
                }

                $.notific8("银行卡状态设置成功！");
            }else{
                $.notific8(data.msg, {theme: 'ebony'});
            }
        });
    });
});


// $(document).ready(function () {
//     $("#s_search").search({
//         '_fnCallback': function () {
//             bind_agent_btn();
//             bind_layer_btn();
//             bind_balance_btn();
//             bind_remark_btn();
//             bind_bonus_btn();
//             bind_water_btn();
//             }}
//         );
//     }
// );

// /****玩家红利*****/
// function bind_balance_btn() {
//     $('a[balance=balance]').on('click', function () {
//         _now_uid = $(this).attr('uid');
//         $('#adjustBalance').modal();
//     });
// }


// function bind_bonus_btn() {
//     $('a[bonus=bonus]').on('click', function () {
//         _now_uid = $(this).attr('uid');
//         $('#adjustBonus').modal();
//     });
// }


// /****玩家备注*****/
// function bind_remark_btn() {
//     $('a[remark=remark]').on('click', function () {
//         _now_uid = $(this).attr('uid');
//         $('#remark').val($(this).prev().attr('data-original-title'));
//         $('#remarkModal').modal();
//     });
// }

// function saveRemark() {
//     var remark = $('#remark').val();
//     var uid = _now_uid;
//     $.post('/player/saveRemark', {uid: uid, remark: remark}, function (data) {
//         data = JSON.parse(data);
//         if (data.code == 200) {
//             $('#remark_' + uid).text(remark).attr('data-original-title', remark).tooltip();
//             $('#remarkModal').modal('hide');
//             $.notific8('备注玩家成功！');
//         } else {
//             $.notific8('备注玩家失败！', {theme: 'ebony'});
//         }
//     });
// }



// /**********玩家代理相关***********/
// function bind_agent_btn() {
//     $('a[agent=agent]').on('click', function () {
//         _now_uid = $(this).attr('uid');
//         var name = $('#an_' + _now_uid).text();
//         var code = $('#ac_' + _now_uid).text();
//         $('#curAgent').text(name + ':' + code);
//         $('#agentModal').modal();
//     });
// }

// /**********玩家调层相关***********/
// function bind_layer_btn() {
//     $('a[layer=layer]').on('click', function () {
//         _now_uid = $(this).attr('uid');
//         $('#layerModal').find('a[group=group]').removeClass('red').addClass('grey-cascade').html('立即选择');
//         $('#layerModal').find('a[groupname="' + $('#' + _now_uid + '_group').html() + '"]').removeClass('grey-cascade').addClass('red').html('已选择');
//         $('#layerModal').modal();
//     });
// }

// $(function () {
//     $('#layerModal').find('a[group=group]').on('click', function () {
//         if (!$(this).hasClass('red')) {
//             var groupid = $(this).attr('groupid');
//             var obj = this;
//             $.post('/player/setGroup', {groupid: groupid, playerid: _now_uid}, function (data) {
//                 if (data.success) {
//                     $.notific8(data.msg);
//                     $('#layerModal').find('a.red').removeClass('red').addClass('grey-cascade').html('立即选择');
//                     $(obj).removeClass('grey-cascade').addClass('red').html('已选择');
//                     $('#' + _now_uid + '_group').html($(obj).attr('groupname'));
//                 } else {
//                     $.notific8(data.msg, {theme: 'ebony'});
//                 }
//             });
//         }

//     });
// });


// /**
//  * 批量调层
//  */
// $(function () {

//     $('#batch_layer_btn').on('click', function () {
//         $('#batchLayerModal').find('a[group=group]').removeClass('red').addClass('grey-cascade').html('立即选择');
//         $('#batchLayerModal').modal();
//     });

//     $('#batchLayerModal').find('a[group=group]').on('click', function () {
//         if (!$(this).hasClass('red')) {
//             var ids = "";
//             $('input[type=checkbox][layer=layer]:checked').each(function () {
//                 ids += $(this).val() + ',';
//             });
//             if (ids == "") {
//                 $.notific8("请选择玩家！", {theme: 'ebony'});
//                 return false;
//             }
//             var groupid = $(this).attr('groupid');
//             var obj = this;
//             $.post('/player/batchSetGroup', {groupId: groupid, playerIds: ids}, function (data) {
//                 if (data.success) {
//                     $.notific8(data.msg);
//                     $('#batchLayerModal').find('a.red').removeClass('red').addClass('grey-cascade').html('立即选择');
//                     $(obj).removeClass('grey-cascade').addClass('red').html('已选择');
//                     $('input[type=checkbox][layer=layer]:checked').each(function () {
//                         $('#' + $(this).val() + '_group').html($(obj).attr('groupname'));
//                     });
//                 } else {
//                     $.notific8(data.msg, {theme: 'ebony'});
//                 }
//             });
//         }
//     });
// });