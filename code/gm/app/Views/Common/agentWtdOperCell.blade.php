<a onclick='refuseSet("{{ $dno }}");' data-toggle='modal' href='#refuseModal' class='btn mini red'><i class='icon-trash'></i>拒绝</a>
<a onclick='passSet("{{ $dno }}", "{{ $amount }}", "{{ $feeType }}", "{{ $fee }}");' data-toggle='modal' href='#passModal' class='btn mini green'><i class='icon-trash'></i>通过</a>