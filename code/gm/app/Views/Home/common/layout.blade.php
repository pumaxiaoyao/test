<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<!-- <html lang="en" class="no-js"> -->
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>{{ $title or "" }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="{{ $desc or " " }}" name="description" />
    <meta content="{{ $author or " " }}" name="author" />
    @include('Home.common.headScript') 
    
    @yield("scripts")

    @yield("scripts1")
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="page-header-fixed page-quick-sidebar-over-content page-style-square page-footer-fixed">
    <!-- BEGIN HEADER -->
    @include('Home.common.navContent')
    @include('Home.common.sideBar')
    @yield('content')
    @yield('modals')
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
</body>
<footer>
    @include('Home.common.footScripts')
    @yield("scripts2")
</footer>
</html>