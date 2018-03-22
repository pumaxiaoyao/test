/**
 * Created by cz on 15/4/7.
 */

var now_transfer_dno = 0;
var playerid,playername,gpid,dno;



//平台转账异常
$(function () {
    $(document.body).on('click', 'a[translate=translate]', function () {
        $('#query_rs').html('<img src="/image/select2-spinner.gif">');
        var parent = $(this).parent().parent();
        now_transfer_dno = $(this).attr('dno');
        $('#m_name').html($(parent).find('td:eq(1)').text());
        $('#m_uid').html($(this).attr('uid'));
        $('#m_amount').html($(parent).find('td:eq(3)').text());
        $('#m_created').html($(parent).find('td:eq(4)').text());
        $('#m_out_name').html($(parent).find('label[out=out]').text());
        $('#m_out_no').html($(this).attr('out_no'));
        $('#m_in_name').html($(parent).find('label[in=in]').text());
        $('#m_in_no').html($(this).attr('in_no'));

         playerid = $(this).attr('uid');
         playername = $(this).attr('playername');
         gpid = $(this).attr('query_gp');
         dno = $(this).attr('query_no');
        setTimeout(function(){gp_query(playerid,playername,gpid,dno);},1000);
    });
});

//主展会转账异常
$(function () {
    $(document.body).on('click', 'a[translate=retranslate]', function () {
        now_transfer_dno = $(this).attr('dno');
    });
});

function checkTransfer(o, frs) {
    $.post('/kzb/gp/transaction/check', {dno: now_transfer_dno, frs: frs}, function (data) {
        if (data.c == 0) {
            if (frs == 1) {
                $.notific8('设置转账成功操作完成！');
            } else {
                $.notific8('设置转账失败操作完成。', {theme: 'ebony'});
            }
            $('#' + now_transfer_dno).remove();
            $(o).next().click();
            $("#btn2close").click();
        } else {
            $.notific8(errorMsg(data), {theme: 'ebony'});
        }
    });
}

var _query_code = {'0': '成功', '1': '请求错误，请重试或联系奇迹客服处理', '2': '转账记录不存在', '3': '系统维护中，请稍后重试或联系奇迹客服处理', '4': '请求的用户不存在'};
var _query_succ = {'-1': '转账记录不存在', '0': '成功', '1': '失败', '2': '未知'};


function gp_query(playerid,playername,gpid,dno){
    $.post('/kzb/gp/transfer/status?playerid=' + playerid + '&playername=' + playername + '&gpid=' + gpid + '&dno=' + dno, function (data) {
        var msg = '';
        if (data.code == 0) {
            var c = data.data['c'];
            var s = data.data['s'];
            if (c == 0) {
                if(s == 0){
                    msg = '<label class="btn btn-xs green">转账成功</label>，可点击下面的绿色按钮';
                }else if(s == 1 || s == -1){
                    msg = '<label class="btn btn-xs red">转账失败</label>，（'+_query_succ[s]+'），可点击下面的红色按钮';
                }else if(s == 2){
                    msg = '<label class="btn btn-xs gray">未知</label>，<label style="color: #ff0000">请将上述信息发给奇迹在线客服，进行人工查询</label>';
                }
            } else if(c == 1) {//请求错误
                msg = '<label class="btn btn-xs gray">未知</label>，(请求接口错误)<a onclick="gp_query(playerid,playername,gpid,dno)">点此重新自助查询</a>，<label style="color: #ff0000">也可将上述信息发给奇迹在线客服，进行人工查询</label>';
            }else if( c == 2){//转账记录不存在
                msg = '<label class="btn btn-xs red">转账失败</label>，('+_query_code[c]+')，可点击下面的红色按钮';
            }else if( c == 3){//系统维护
                msg = '<label class="btn btn-xs gray">未知</label>，（系统维护）<label style="color: #ff0000">请将上述信息发给奇迹在线客服，进行人工查询</label>';
            }else if( c==4){//用户不存在
                msg = '<label class="btn btn-xs red">转账失败</label>，可点击下面的红色按钮';
            }
        } else {
            msg = '<label class="btn btn-xs gray">未知</label>，（getError(data.code);）<label style="color: #ff0000">请将上述信息发给奇迹在线客服，进行人工查询</label>';
        }
        $('#query_rs').html(msg);
    });
}


function checkListTransfer(){
    var a = $("tr[error_type=2]:first");
    if(a.length==0){$.notific8('目前暂无需要批量处理的情况或已处理完毕');window.location.reload();return false;}
    else{
        a.hide();
        $.post('/kzb/gp/transaction/check', {dno: $(a).attr('id'), frs: 2}, function (data) {
            if (data.c == 0) {
                $(a).remove();
            } else {
                $(a).attr('error_type','3');
            }
            checkListTransfer();
        });
    }
}

$(document).ready(function() {
    $('#s_search').search({"_fnCallback": function (resp) {
            $('#data tbody > tr').find('td:eq(3)').css('text-align', 'right');
        }
    });
});