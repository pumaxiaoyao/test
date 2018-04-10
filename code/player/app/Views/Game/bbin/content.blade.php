<div class="live-list" style="text-align: center; background: url('/static/img/sportsbook.jpg') no-repeat #3c5da9">
    <div style="margin:auto auto auto auto; position: relative; height: 720px;width:1190px;">
        {{--  <iframe id="main-frame" style="width: 100%; height: 100%;" name="main-frame" scrolling="no" frameborder="0" src=""></iframe>  --}}
        <form id="game1" method="post"  action={{ $url or ""}}>
            <input id="game1btn" type="submit" class="game1" value="游戏1" />
        </form>

    </div>
</div>
<style type="text/css">
.game1 {
    height:40px;
    width:160px;
    border-radius:20px;
    background:#fff;
    display:inline-block;
    line-height:40px;
    text-decoration:none;
    position:absolute;
    left:50%;
    margin-left:-80px;
    bottom:500px;
}

</style>


