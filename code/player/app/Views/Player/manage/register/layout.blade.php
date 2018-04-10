<!DOCTYPE html>
<html lang="en" style="height: 100%">
    <head>
        <title>{{ $title or '' }}</title>    
        <meta charset="utf-8">    
        <meta name="viewport" content="width=device-width, initial-scale=1">    
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="keywords" content="{{ $keywords or '' }}" />
        <meta name="description" content="{{ $description or '' }}" />
        {{--  包含通用的脚本 --}}
        @include('Player.Common.headerScripts')
        @yield("scripts")
    </head>
    
    <body style="height: 100%;padding:0;margin:0;">
        {{-- 继承后插入的内容 --}}
        @yield('content')
    </body>

    <footer>
        @include("Player.manage.register.footer")
    </footer>
</html>

    
    