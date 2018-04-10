<script>
    var GameStatus = 1;
</script>
<script type="text/javascript">
    $(function () {
        if (GameStatus == 1) {
            $.ajax({
                type: "post",
                url: "/game/LoginBBinGame",
                contentType: "application/json; charset=utf-8",
                data: { "MemberName" : "{{ $LoginMemberName }}"},
                dataType: "json",
                success: function (datas) {
                    var resp = datas.data;
                    $("#game1").attr("action", resp[1]);
                },
                error: function (err) {
                }
            }, 'json');
        }else if(GameStatus == 2){
            $("#main-frame").attr("src", "maintenance.aspx");
        }
    });
</script>