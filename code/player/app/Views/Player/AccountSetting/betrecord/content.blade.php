<div class="as_fl20_right">
    <div class="as_bet_zz">
        <div class="as_bet_zz_title">
            <h3>投注记录<b>| 每个产品的数据将有一定时间的延迟，仅供参考使用</b></h3>
            <span>选择日期：
            <a id="history_today"  onclick="searchHistory('today','')">今天</a>
            <a id="history_3day" onclick="searchHistory('3day','')" >三天内</a>
            <a id="history_week" onclick="searchHistory('week','')" >一周内</a>
            <a id="history_month" onclick="searchHistory('month','')" >一个月内</a>
        </span>
        </div>
        <div class="as_bet_zz_table">
            <table>
                <tr>
                    <th>产品</th>
                    <th>笔数</th>
                    <th>投注流水</th>
                    <th>输赢</th>
                </tr>
                <?php
                    $totalCounts = 0;
                    $totalAmount = 0;
                    $totalResult = 0;
                ?>
                @foreach ($BetRecords as $gpId=>$_record)
                <?php
                $totalCounts += (int)$_record["data"]["count"];
                $totalAmount += (float)$_record["data"]["stake"];
                $totalResult += (float)$_record["data"]["winLose"];
                ?>
                <tr>
                    <td>{{ $_record["name"] }}</td>
                    <td class="blue"><a onclick="searchHistory('','{{ $gpId }}')">{{ $_record["data"]["count"] }}</a></td>
                    <td>{{ $_record["data"]["stake"] }}</td>
                    <td>
                        @if ($_record["data"]["winLose"] > 0)
                            <span class="green">{{ $_record["data"]["winLose"] }}</span> 
                        @else
                            <span class="red">{{ $_record["data"]["winLose"] }}</span> 
                        @endif
                    </td>
                </tr>
                @endforeach
                <tr class="total">
                    <td>总计</td>
                    <td>{{ $totalCounts }}</td>
                    <td>{{ $totalAmount }}</td>
                    <td>
                        @if ($totalResult > 0)
                            <span class="green">{{ $totalResult }}</span> 
                        @else
                            <span class="red">{{ $totalResult }}</span> 
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</div>
</div>