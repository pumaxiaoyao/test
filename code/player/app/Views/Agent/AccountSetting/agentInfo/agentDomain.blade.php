@foreach ($AgentDomains as $domain)
<tr>
    <td>合营域名</td>
    <td style="float:left;text-align:center">{{ $domain["domain"] or ""}} </td>
</tr>
@endforeach