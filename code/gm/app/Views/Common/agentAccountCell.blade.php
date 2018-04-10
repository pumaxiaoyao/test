<span class='label label-info' style='cursor:pointer;' onclick="custom_getAgentModel('{{ $agentId }}','{{ $agentAccount }}');">
@if ($type == 1)
    {{ $agentId }}
@else 
    {{ $agentAccount }}
@endif
</span>