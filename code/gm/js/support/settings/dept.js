/**
 * Created by cz on 15/8/10.
 */

$(function(){
    $('a[perm=perm]').on('click',function(){
       var deptId = $(this).attr('deptId');
        $('#content').load('/settings/deptPerm?deptId='+deptId,function(response,status,xhr){
            if(status == 'success'){
                $('#module_tree').on('before_open.jstree',function(){
                    //$('#module_tree').find('a[module=module] > .jstree-checkbox').remove();
                }).jstree({
                    'plugins': [ "checkbox", "types"],
                    "core" : {
                        "themes" : {
                            "responsive": false
                        }
                    },
                    "types" : {
                        "default" : {
                            "icon" : "fa fa-folder icon-state-warning icon-lg"
                        },
                        "file" : {
                            "icon" : "fa fa-file icon-state-warning icon-lg"
                        }
                    }
                });

                $('#editModal').modal();
            }else{
                alert('未知错误！');
            }

        });
    });

    $('#btn_save_permission').on('click',function(){
        var nodes = $("#module_tree").jstree('get_selected',true);
        var len = nodes.length;
        var authIds = '';
        if(len > 0){
            for(var i = 0;i < len;i++){
                var li_attr = nodes[i].li_attr;
                if(li_attr.auth){
                    authIds += li_attr.authid + ',';
                }
            }
        }
        var deptId = $('#module_tree').attr('dept');
        $.post('/settings/savePrem',{deptId:deptId,authIds:authIds},function(data){
            if(data.success){
                $('#editModal').modal('hide');
                $("#module_tree").html('');
                $.notific8('编辑部门权限成功！');
            }else{
                $.notific8('编辑部门权限失败！', {theme: 'ebony'});
            }
        });
    });
});