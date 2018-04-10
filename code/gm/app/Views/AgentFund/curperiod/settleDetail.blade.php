

<table class="table table-striped table-bordered table-hover table-full-width">
    <thead>
        <tr>
            <th rowspan="2">游戏平台</th>
            <th colspan="3">抽佣收入计算</th>
            <th colspan="3">抽水收入计算</th>
        </tr>
        <tr>
            <th >公司输赢</th>
            <th >抽佣比例</th>
            <th >输赢抽佣</th>
            <th >有效投注</th>
            <th >抽水比例</th>
            <th >洗码抽水</th>
        </tr>
    </thead>
    <tbody>
        {!! $GameCommisionData !!}
    </tbody>
</table>
<table class="table table-striped table-bordered table-hover table-full-width">
    <thead>
        <tr>
            <th >代理账号</th>
            <th >抽佣收入</th>
            <th >抽水收入</th>
            <th >平台合计</th>
            <th >线路费</th>
            <th colspan="2">代理线佣金</th>
        </tr>
    </thead>
    <tbody>
        {!! $ChildCommisionData !!}
    </tbody>
</table>