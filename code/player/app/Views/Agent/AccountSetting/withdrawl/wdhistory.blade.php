@foreach ($wdHistoryData as $_history)
<tr>
    <td>
        {{ $_history["time"] }}
    </td>
    <td>
        {{ $_history["dno"] }}
    </td>
    <td>
        {{ $_history["amount"] }}
    </td>
    <td>
        {{ $_history["wdfee"] }}
    </td>
    <td>
        {{ $_history["applyAmount"] }}
    </td>
    <td>
        {{ $_history["checkStatus"] }}
    </td>
    <td>
        {{ $_history["note"] }}
    </td>
</tr>
@endforeach