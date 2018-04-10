<script>
    var GameStatus = 1;
</script>


<script type="text/javascript">
    $(function () {
        if (GameStatus == 1) {
            $.ajax({
                type: "post",
                url: "/game/GetLBCPLogin",
                contentType: "application/json; charset=utf-8",
                data: { "MemberName" : "<?php echo e($LoginMemberName); ?>" },
                dataType: "json",
                success: function (datas) {
                    var resp = datas.data;
                    $("#main-frame").attr("src", resp[1]);
                },
                error: function (err) {
                }
            }, 'json');
        }else if(GameStatus == 2){
            $("#main-frame").attr("src", "maintenance.aspx");
        }
    });
</script>
