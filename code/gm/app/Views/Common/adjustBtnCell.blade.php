@if ($checkStatus == 1)
<a href='#adjustModal' data-toggle='modal' onclick="adjuststart('{{ $dno }}', '{{ $adjustmentAmount }}');" class='btn btn-xs green'><i class='fa fa-edit'></i>{{ $adjustmentAmount }}</a>
@else
{{ $adjustmentAmount }}
@endif