$(document).ready(function () {
    console.log(22222);
    $("#s_search").search({
        "bAutoWidth": false, "_fnCallback": function (resp) {
            console.log(33333);
            resp = resp.data;
            console.log("resp is " + resp);
            var tr = $('#data tbody > tr');
            tr.find('td:eq(2)').css('text-align', 'right');
            tr.find('td:eq(4),td:eq(7)').css('text-align', 'left');
            $("#total").text(1111111111111);
            $("#dpt").text(resp.dpt);
            $("#wtd").text(resp.wtd);
            $("#bonus").text(resp.bonus);
            $("#rakeback").text(resp.rakeback);
            $("#trans").text(resp.trans);

            $("#pdpt").text(resp.pdpt);
            $("#pwtd").text(resp.pwtd);
            $("#pbonus").text(resp.pbonus);
            $("#prakeback").text(resp.prakeback);
            $("#ptrans").text(resp.ptrans);
        }
    });
});