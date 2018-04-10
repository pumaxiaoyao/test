<div class="live-list" style="text-align: center; background: url('/static/img/sportsbook.jpg') no-repeat #3c5da9">
    <div style="margin:auto auto auto auto; position: relative; height: 720px;width:1190px;">
        
        <form id="game1" method="post"  action=<?php echo e(isset($url) ? $url : ""); ?>>
            <input id="game1btn" type="submit" class="game1" value="游戏1" />
        </form>

        <form id="game6" method="post"  action=<?php echo e(isset($url) ? $url : ""); ?>>
            <input id="game6btn" type="submit" class="game2" value="游戏6" />
        </form>

        <form id="game8" method="post" action=<?php echo e(isset($url) ? $url : ""); ?>>
            <input id="game8btn" type="submit" class="game3" value="游戏8" />
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

.game2 {
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
    bottom:300px;
}

.game3 {
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
    bottom:80px;
}
</style>


