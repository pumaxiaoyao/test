<script type="text/javascript" src="/static/js/support/agent.js"></script>
        <script type="text/javascript">
            $("#s_search").search({
                    "_fnCallback": function (resp) {
                        $("#total").text(resp.iTotalRecords);
                    }
                });
        </script>