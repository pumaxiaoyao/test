@if ($checkStatus == 1)
<a href='#acturalModal' data-toggle='modal' onclick="acturalstart('{{ $dno }}','{{ $commisionResultAmount }}', '{{ $platformCommision }}');"
    class='btn btn-xs green'><i class='fa fa-edit'></i>{{ $commisionResultAmount }}</a> @else {{ $commisionResultAmount }} @endif