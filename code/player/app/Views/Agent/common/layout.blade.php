<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $title or '' }}</title>    
        <meta charset="utf-8">    
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="keywords" content="{{ $keywords or '' }}" />
        <meta name="description" content="{{ $description or '' }}" />
        {{--  包含通用的脚本 --}}
        @include('Agent.common.headerScripts')
        {{--  导入模块自用的脚本  --}}
        @yield("scripts")
    </head>
    <body>
        {{--  包含页头导航信息  --}}
        @include('Agent.common.navigate')

        {{-- 继承后插入的内容 --}}
        @yield('content')
    </body>
    <footer>
        {{-- 包含页脚 --}}
        @include('Player.Common.footer')
    </footer>
</html>

    
    