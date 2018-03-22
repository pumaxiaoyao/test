/**
 * Created by cz on 15/8/25.
 */
$(document).ready(function () {
    $("#s_search").search({
        'bSort':true,
        //'iDisplayLength':30
        'aoColumnDefs':[
            { "bSortable": false, "aTargets": [ 0 ] },
            { "bSortable": false, "aTargets": [ 1 ] },
            { "bSortable": false, "aTargets": [ 2 ] },
            { "bSortable": true, "aTargets": [ 3 ] },
            { "bSortable": true, "aTargets": [ 4 ] },
            { "bSortable": false, "aTargets": [ 5 ] },
            { "bSortable": false, "aTargets": [ 6 ] },
            { "bSortable": false, "aTargets": [ 7 ] },
            { "bSortable": false, "aTargets": [ 8 ] },
            { "bSortable": false, "aTargets": [ 9 ] },
        ],
        '_fnCallback':function(data){
            $('#amount').html(data.amount);
            $('#total_amount').html(data.total_amount);
        }
    });
});