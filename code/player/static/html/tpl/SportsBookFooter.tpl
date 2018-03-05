
    <script type="text/javascript">
        $(function () {
            if (SportStatus == 1) {
                $.ajax({
                    type: "post",
                    url: "/demo.php?m=sportsbook",
                    contentType: "application/json; charset=utf-8",
                    data: null,
                    dataType: "text",
                    success: function (datas) {
                        console.log(datas);
                        $("#main-frame").attr("src", datas);
                    },
                    error: function (err) {
                    }
                }, 'text');
            }else if(SportStatus == 2){
                $("#main-frame").attr("src", "maintenance.aspx");
            }
        });
    </script>
