<div class="as_fl20_right">
    <div class="as_bet_email">
        <div class="as_email_title">
            <h3>站内信</h3>
        </div>
        <div class="email_title_box">
            <div id="take_email" class="take_email email_nr" style="display:block">
                <table>
                    <tr>
                        <th width="5%"></th>
                        <th width="20%">时间</th>
                        <th>标题</th>
                        <th width="10%">状态</th>
                    </tr>
                    @foreach ($recvMails as $email)
                        <tr value="{{ $email["recordNum"] }}" class="ms_table_row">
                            <td></td>
                            <td>{!! date("Y-m-d H:i:s", $email["recordTime"]) !!}</td>
                            <td><a href='javascript:void(0);' onclick="writeMessage(this, '{{ $email["recordNum"] }}',1)" >{{ $email["title"] }}</a></td>
                            <td class="message_isView">{{ $email["messageStatus"] == 1 ? "未读" : "已读"}}</td>
                        </tr>
                    @endforeach

                    @if ($maxPage > 1)
                    <tr><td colspan="5" style="background:#f5f5f5"><span class="page"><strong>
                        @for ($i = 1; $i < $maxPage + 1; $i++)
                            @if ($i == $curPage)
                                <strong><span>{{ $i }}</span></strong>
                            @else 
                                <a href="receivebox?pageIndex={{ $i }}"><span>{{ $i }}</span></a>
                            @endif

                            @if ($i == $maxPage)
                                </strong><a  href="receivebox?pageIndex={{ $i }}" class="nextPage"><span>下一页</span></a></span></td></tr>
                            @endif
                        @endfor
                    @endif
                    <tr>
                        <td colspan="5" style="background:#f5f5f5"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div>
</div>
</div>