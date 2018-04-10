<script type="text/javascript">
    $('#iptPlayerList').bind('keypress',function(event){
        if(event.keyCode == "13")
        {
            searchU();
        }
        });
        
        $("#btnSearchPlayer").click(function() {
            searchU();
        });
    
        function searchU(){
            var key = $("#iptPlayerList").val();
            $.get("/player/playerListModel?k="+key,function(data){
                $("#playerlistmodel").parent().html(data);
            });
        }
        function selectPlayer(o,fn){
            var uid= $("#setPlayerList").val();
            var udisplay= $("#setPlayerList").find("option:selected").text();
            $(o).next().click();
            if(selectUser)selectUser(uid,udisplay);
        }
</script>