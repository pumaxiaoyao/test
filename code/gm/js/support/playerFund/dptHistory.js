$(document).ready(function () {

    var s_type = '', 
        s_keyword = '', 
        s_transtype = '',
        s_StartTime = '',
        s_EndTime = '',
        s_dpttype = '',
        dno = '';


    $("#s_search").search({
        "_fnCallback": function (resp) {
            if($("#s_type").val() != null || $("#s_type").val() != undefined){
         s_type = $("#s_type").val();
    }

    if($("#s_keyword").val() != null || $("#s_keyword").val() != undefined){
         s_keyword = $("#s_keyword").val();
    }

    if($("#s_transtype").val() != null || $("#s_transtype").val() != undefined){
         s_transtype = $("#s_transtype").val();
    }

    if($("#s_StartTime").val() != null || $("#s_StartTime").val() != undefined){
         s_StartTime = $("#s_StartTime").val();
    }

    if($("#s_EndTime").val() != null || $("#s_EndTime").val() != undefined){
         s_EndTime = $("#s_EndTime").val();
    }

    if($("#s_dpttype").val() != null || $("#s_dpttype").val() != undefined){
         s_dpttype = $("#s_dpttype").val();
    }

    if($("#dno").val() != null || $("#dno").val() != undefined){
         dno = $("#dno").val();
    }

    var json = {
                's_type': s_type, 
                's_keyword': s_keyword, 
                's_transtype':s_transtype, 
                's_StartTime':s_StartTime, 
                's_EndTime':s_EndTime, 
                's_dpttype':s_dpttype, 
                'dno':dno
                };

            // getTotalDeposit(json);
             $("#pdps").text(resp.pdps);
             $("#dps").text(resp.dps);
            $('#data tbody > tr').find('td:eq(3),td:eq(4),td:eq(5),td:eq(6),td:eq(7)').css('text-align', 'right');
            bindReset();
        },
    });
});

function resetAlert() {
    layer.msg('无法重置！', {icon: 2});
}

function bindReset() {
    $("a[reset=reset]").on("click", function () {
        $("#dno").val($(this).attr("dno"));
        $("#resetModal").modal();
    });
}

function commitReset() {
    layer.load(2);
    var dno = $("#dno").val();
    var remark = $("#remark").val();
    if (isEmpty(remark)) {
        layer.closeAll('loading');
        $.notific8("备注不能为空！", {theme: 'ebony'});
        return false;
    }

    $.ajax({
        "url": "/playerfund/reset",
        "data": {dno: dno, remark: remark},
        "error": function (data) {
            layer.closeAll('loading');
        },
        "type": "post",
        "success": function (data) {
            data = JSON.parse(data);
            layer.closeAll('loading');
            if (data.code == 200) {
                $.notific8(data.Message);
                target[1].fnReloadAjax();
                $("#resetModal").modal("hide");
                // window.location.reload();
            } else {
                $.notific8(data.Message, {theme: 'ebony'});
            }
        }
    });

}

function getTotalDeposit(data) {
    $.ajax({
        url: "/playerfund/getTotalDeposit",
        type: "POST",
        data: {
                dno: data.dno, 
                s_type: data.s_type, 
                s_keyword: data.s_keyword, 
                s_dpttype: data.s_dpttype, 
                s_transtype: data.s_transtype, 
                s_EndTime: data.s_EndTime, 
                s_StartTime: data.s_StartTime
              },
        success: function (data) {
            // console.log(data);
            // $("#dc").text(resp.dc);
            $("#ac").text(data);
        }
    });
}