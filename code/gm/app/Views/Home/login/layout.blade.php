<!-- 4 -->
<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>{{ $title or '' }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="keywords" content="{{ $keywords or '' }}" />
    <meta name="description" content="{{ $description or '' }}" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    @include('Home.login.headScript')
    @yield("scripts")
</head>
<body class="login">
    {{-- 继承后插入的内容 --}}
    @yield('content')
</body>
<footer>
    @include('Home.login.footScripts')
</footer>
</html>

    
    