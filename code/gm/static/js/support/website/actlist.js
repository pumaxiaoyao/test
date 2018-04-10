/**
 * Created by cz on 15/4/17.
 */


var _status_dict = {'11':'待上架','22':'已上架','25':'已下架','32':'已删除'};

function changeStatus(obj,actid,status){
    var action = $(obj).html();
    $.post('/kzb/activity/status',{actid:actid,status:status},function(data){
        if(data.c == 0){
            $.notific8(action+'活动成功！');
            $('#status_'+actid).html(_status_dict[status]);
        }else{
            $.notific8(action+'活动失败！', {theme: 'ebony'});
        }
    });
}