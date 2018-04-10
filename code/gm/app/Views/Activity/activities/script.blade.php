<script type="text/javascript">
    $(document).ready(function(){
        $("#s_search").search();
    });
    var _status_dict = {'0':'待上架','1':'已上架','2':'已下架','3':'已删除'};
     
    function modifyStatus(obj, actid, status){
        var action = $(obj).html();
        $.post('/activity/changeStatus',{actid: actid, status: status},function(data){
            data = JSON.parse(data);
            resp = data.data;
            if(resp[0]){
                $.notific8(action+'活动成功！');
                $('#status_'+actid).html(_status_dict[status]);
            }else{
                $.notific8(action+'活动失败！', {theme: 'ebony'});
            }
        });
    }

</script>