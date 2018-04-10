@if (count($domains) > 0) @foreach ($domains as $index => $_domain)
<tr>
    <td style="cursor:hand;text-align: left;">
        <font style=color:red;>{{ $_domain["domain"]}}</font>
    </td>
</tr>@endforeach @else
<tr>
    <td style=\ "cursor:hand;text-align: left;\">无数据</td>
</tr>
@endif