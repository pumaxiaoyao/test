@foreach($historyRecords as $_history)
    <tr>
        <td>{{ $_history["account"] }}</td>
        <td>{{ $_history["dno"] }}</td>
        <td>{!! $_history["time"] !!}</td>
        <td>{!! $_history["content"] !!}</td>
        @if ( $_history["winloss"] > 0) 
            <td class='green'>赢</td>
            <td>{{ $_history["amount"] }}</td>
            <td class='green'>{{ $_history["winloss"] }}</td>
        @else
            <td class='red'>输</td>
            <td>{{ $_history["amount"] }}</td>
            <td class='red'>{{ $_history["winloss"] }}</td>
        @endif
    </tr>
@endforeach