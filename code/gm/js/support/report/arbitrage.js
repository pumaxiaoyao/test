/**
 * Created by cz on 16/1/29.
 */

$(document).ready(function () {
    $("#s_search1").search({
        'tbId':'data1',
        's_search':'s_search1',
        'stateSave':true,
        'target':1,
        "_fnCallback": function (resp) {
            get_ip_info();
        }
    });
    $("#s_search2").search({
        'tbId':'data2',
        's_search':'s_search2',
        'stateSave':true,
        'target':2,
        "_fnCallback": function (resp) {
            get_ip_info();
        }
    });
    $("#s_search3").search({
        'tbId':'data3',
        's_search':'s_search3',
        'stateSave':true,
        'target':3,
        "_fnCallback": function (resp) {
            get_ip_info();
        }
    });
});


function get_ip_info(){
    $('label[ipTag=ipTag]').each(function(){
        var ip = $(this).attr('ip');
        var obj = $(this);
        if(ip!=""&&ip!=null){
            if(ip.indexOf(".")!=-1){
                ip = ip.split(".");
                ip = ip[0]+"."+ip[1]+"."+ip[2]+".1";
                $.ajax({
                    url: '/site/getIpInfo',
                    type: 'get',
                    dataType: 'json',
                    data:{ip:ip},
                    cache:true,
                    error: function () {

                    },
                    success: function (data) {
                        var text = '获取IP信息失败!';
                        if(data.code == 0){
                            text = data.data['country']+data.data['region']+data.data['city'];
                        }
                        $(obj).html(text);
                    }});
            }
        }
    });
}