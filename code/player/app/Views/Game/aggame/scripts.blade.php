<script>
    var GameStatus = 1;
</script>
<script type="text/javascript">
    $(function () {
        if (GameStatus == 1) {
            var validGame = [1, 6, 8];
            validGame.forEach(gameId => {
                $("#game" + gameId).attr("action", "");
                $("#game" + gameId +"btn").hide();
                $.ajax({
                    type: "post",
                    url: "/game/LoginAgGame",
                    contentType: "application/json; charset=utf-8",
                    data: { "MemberName" : "{{ $LoginMemberName }}",
                            "gameId" : gameId },
                    dataType: "json",
                    success: function (datas) {
                        var resp = datas.data;
                        if (resp[1]) {
                            $("#game" + gameId ).attr("action", resp["url"]);
                            $("#game" + gameId + "btn").show();     
                        } else {
                            alert(resp[2]);
                            }
                    },
                    error: function (err) {
                    }
                }, 'json');
             });
        }else if(GameStatus == 2){
            $("#main-frame").attr("src", "maintenance.aspx");
        }
    });
</script>