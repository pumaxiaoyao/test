/**
 * Created by cz on 16/1/26.
 */

$(document).ready(function () {
    $('#add_btn').on('click', function () {
        $('#cateId').val(0);
        $('#name').val('');
        $('#desc').val('');
        $('#status').val('');
        $('#act_cate_modal').modal();
        $('#act_cate_modal').find('#title').text("新增活动类型");
    });

    $('a[edit=edit]').on('click', function () {
        $('#cateId').val(this.getAttribute('cateId'));
        $('#name').val(this.getAttribute('name'));
        $('#desc').val(this.getAttribute('desc'));
        $('span.checked').removeClass('checked');
        var status = this.getAttribute('status');
        $('input[value='+status+']').parent().addClass('checked');
        $('#act_cate_modal').modal();
        $('#act_cate_modal').find('#title').text("编辑活动类型");
    });

    $('#btn_save').on('click', function () {
        var cateId = $('#cateId').val();
        var name = $('#name').val();
        var desc = $('#desc').val();
        var status = $('span.checked').find('input').val();
        $.post('/activity/editCate', {cateId: cateId, name: name, desc: desc, status: status}, function (data) {
            data = JSON.parse(data);
            resp = data.data;
            if(resp[0]){
                $.notific8('编辑成功');
                window.location.reload();
                // target[1].fnReloadAjax();
            }else{
                $.notific8('编辑失败！', {theme: 'ebony'});
            }
        });
    });
});