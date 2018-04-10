/**
 * Created by cz on 15/9/1.
 */

$(document).ready(function () {
    $("#s_search").search({
        'bSort':true,
        //'iDisplayLength':30
        'aoColumnDefs':[
            { "bSortable": false, "aTargets": [ 0 ] },
            { "bSortable": false, "aTargets": [ 1 ] },
            { "bSortable": false, "aTargets": [ 2 ] },
            { "bSortable": false, "aTargets": [ 3 ] },
            { "bSortable": false, "aTargets": [ 4 ] },
            { "bSortable": false, "aTargets": [ 5 ] },
            { "bSortable": false, "aTargets": [ 6 ] },
            { "bSortable": true, "aTargets": [ 7 ] },
            { "bSortable": true, "aTargets": [ 8 ] },
            { "bSortable": true, "aTargets": [ 9 ] },
            { "bSortable": true, "aTargets": [ 10 ] },
            { "bSortable": false, "aTargets": [ 11] },
            { "bSortable": false, "aTargets": [ 12] },
            { "bSortable": false, "aTargets": [ 13] },
            { "bSortable": false, "aTargets": [ 14] },
            { "bSortable": false, "aTargets": [ 15 ] },
            { "bSortable": false, "aTargets": [ 16 ] },

        ],
        '_fnCallback': function () {
            getdata();
        }
    });
    $('#selAll').on('click', function () {
        $('#data').find('input[layer=layer]').prop('checked', $(this).is(':checked'));
    });
});

var loading = false;
function getdata() {
    if(loading==true){return;}
        var u = $("#data").find("span[load=false]:first");
        if(u.length==0)return;
        var uid = u.attr("uid");
        var start = u.attr("s");
        var end = u.attr("e");
        loading=true;
        $.ajax({
            url :'/player/playerWinloss?uid='+uid+'&start='+start+'&end='+end,
            type:'get',
            dataType: 'json',
            success : function(data) {
                var tr = $("#data").find("span[uid="+uid+"]").parent().parent();
                tr.find("span[index=1]").html(formatCurrency(data.betamt)).attr("load","true");
                tr.find("span[index=2]").html(formatCurrency(data.payout));
                tr.find("span[index=3]").html(formatCurrency(data.winloss*-1)).css("color",data.winloss>0?"red":"green");
                tr.find("span[index=4]").html(formatCurrency(data.validamt));

                loading = false;
                getdata();
            },
            error : function(){

                loading = false;
                getdata();
            },
            cache : false
        });
}

function formatCurrency(num) {
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + ',' +
            num.substring(num.length - (4 * i + 3));
    return (((sign) ? '' : '-') + num + '.' + cents);
}

/**
 * 批量调层
 */
$(function () {
    $('#batch_layer_btn').on('click', function () {
        $('#batchLayerModal').find('a[group=group]').removeClass('red').addClass('grey-cascade').html('立即选择');
        $('#batchLayerModal').modal();
    });

    $('#batchLayerModal').find('a[group=group]').on('click', function () {
        if (!$(this).hasClass('red')) {
            var ids = "";
            $('input[type=checkbox][layer=layer]:checked').each(function () {
                ids += $(this).val() + ',';
            });
            if (ids == "") {
                $.notific8("请选择玩家！", {theme: 'ebony'});
                return false;
            }
            var groupid = $(this).attr('groupid');
            var obj = this;
            $.post('/player/batchSetGroup', {groupId: groupid, playerIds: ids}, function (data) {
                if (data.success) {
                    $.notific8(data.msg);
                    $('#batchLayerModal').find('a.red').removeClass('red').addClass('grey-cascade').html('立即选择');
                    $(obj).removeClass('grey-cascade').addClass('red').html('已选择');
                    $('input[type=checkbox][layer=layer]:checked').each(function () {
                        $('#' + $(this).val() + '_group').html($(obj).attr('groupname'));
                    });
                } else {
                    $.notific8(data.msg, {theme: 'ebony'});
                }
            });
        }
    });
});