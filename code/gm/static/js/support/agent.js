function custom_getAgentModel(aid, acct) {
    if ($("#custom_AgentModal").length > 0) {
        $("#custom_AgentModal").remove();
    }
    if ($("#custom_AgentModelbtn").length == 0) {
        $(document.body).append('<a href="#custom_AgentModal" id="custom_AgentModelbtn" data-toggle="modal" class="hide btn btn-xs green">查看</a>');
    }
    var html = '';
    html += '<div class="modal fade" id="custom_AgentModal" tabindex="-1" role="basic" aria-hidden="true">';
    html += '<div class="modal-dialog modal-full">';
    html += '    <div class="modal-content">';
    html += '        <div class="modal-header">';
    html += '            <button class="close" type="button" data-dismiss="modal">×</button>';
    html += '            <h3>代理信息：' + aid + '</h3>';
    html += '        </div>';
    html += '        <div class="modal-body">';
    html += '        </div>';
    html += '         <div class="modal-footer">';
    html += '            <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>';
    html += '        </div>';
    html += '    </div>';
    html += '</div>';
    html += '</div>';
    html += '';
    $(document.body).append(html);
    $.get("/agent/detailBox?id=" + aid, function (data) {
        $("#custom_AgentModal").find('.modal-body').html(data);

        $("#custom_AgentModelbtn").click();
    });
}

function initModal(id) {
    $('#editModal').find("#aid").val(id);
    var aname = "";
    var email = "";
    var phone = "";
    var qq = "";
    $.ajax({
        type: "post",
        url: "/agent/getAgentInfo",
        data: {id :id},
        error:function(){
            $.notific8("未知错误，请联系管理员！", {theme: 'ebony'});
        },
        success: function (d) {
            d = JSON.parse(d);
            ret = d.data;
            $('#editModal').find("#realname").val(ret.name);
            $('#editModal').find("#email").val(ret.email);
            $('#editModal').find("#mobile").val(ret.cellPhoneNo);
            $('#editModal').find("#qq").val(ret.qq);
            reset();
        }
    });

    // $('#editModal').modal();
}

function reset() {
    $('#edit_form').find('i.fa-warning').removeClass('fa-warning');
    $('#edit_form').find('div.has-error').removeClass('has-error');
    $('#edit_form').find('i.fa-check').removeClass('fa-check');
    $('#edit_form').find('div.has-success').removeClass('has-success');
}