/**
 * Created by cz on 15/4/21.
 */

var _gp_status_ = {11:'<span class="label label-warning">关闭</span>',88:'<span class="label label-success">正常</span>'};

function initModal(gpId){
    clearModal();
    $('#type').val("gp");
    $('#gpid').val(gpId);
    $(".modal-title").html("编辑游戏平台");
    $("#showname").html("游戏平台名称");
    $.get('/settings/getGpInfo',{gpId:gpId},function(data){
        $('#gpName').val(data.gpname);
        $('#gpOrder').val(data.displayorder);
        $('#gpStatus').find('input[name=status]:checked').prop('checked',false).parent().removeClass('checked');
        $('#gpStatus').find('input[name=status][value='+data.status+']').prop('checked',true).parent().addClass('checked');
    });
}

function initModala(gpId){
    clearModal();
    $('#type').val("account");
    $('#gpid').val(gpId);
    $(".modal-title").html("编辑游戏平台主账户");
    $("#showname").html("主账户名称");
    $.get('/settings/getGpaInfo',{gpId:gpId},function(data){
        $('#gpName').val(data.gpname);
        $('#gpOrder').val(data.displayorder);
        $('#gpStatus').find('input[name=status]:checked').prop('checked',false).parent().removeClass('checked');
        $('#gpStatus').find('input[name=status][value='+data.status+']').prop('checked',true).parent().addClass('checked');
    });
}


function savePlatform(o){
    var type = $('#type').val();
    var url = type=="gp"?'/settings/saveGpInfo':'/settings/saveGpaInfo';
    var name = $('#gpName').val();
    var order = $('#gpOrder').val();
    var status = $('#gpStatus').find('input[name=status]:checked').val();
    var gpId = $('#gpid').val();
    $.post(url,{gpId:gpId,name:name,order:order,status:status},function(data){
        if(data.success){
            $.notific8('编辑平台信息成功！');
            updateGpTr($('#type').val(),gpId,name,order,status);
            $(o).next().click();
        }else{
            $.notific8(data.msg, {theme: 'ebony'});
        }
    });
}

function clearModal(){
    $('#gpName').val('');
    $('#gpOrder').val('');
    $('#gpStatus').find('input[name=status]:checked').prop('checked',false).parent().removeClass('checked');
}

function updateGpTr(type,gpId,name,order,status){
    var i = type=="gp"?1:0;
   var tds = $('#'+type+'_'+gpId).find('td');
    $(tds[i]).html(name);
    $(tds[i+1]).html(order);
    showStatus($(tds[i+2]),status);
}

function showStatus($obj,status){
    $obj.html(_gp_status_[status]);
}
