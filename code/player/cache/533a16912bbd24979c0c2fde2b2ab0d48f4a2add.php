<link href="/static/css/bootstrap.min.css" rel="stylesheet" />
<link href="/static/css/index.css" rel="stylesheet" />
<link href="/static/css/picstyle.css" rel="stylesheet" />

<script>
    $(document).ready(function () {
       $('.regok_three').mouseenter(function(){
                   $(this).animate({'margin-top':'-123px'})
                   $('.regok_two,.regok_one').animate({'margin-top':'-92',})
       });
           $('.regok_one').mouseenter(function(){
                       $(this).animate({'margin-top':'-123px'})
                       $('.regok_two,.regok_three').animate({'margin-top':'-92',})
           });
   
        $('.regok_two').mouseenter(function(){
          $('.regok_three,.regok_one').animate({'margin-top':'-92'});
                      $(this).animate({'margin-top':'-123px'})
   
           })
   
    })
</script>