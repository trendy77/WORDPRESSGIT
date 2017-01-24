<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $settings->site_name }} Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="{{ jasko_component('/uploads/' . $settings->favicon )  }}" type="image/x-icon">

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ jasko_component('/components/adminlte/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ jasko_component('/components/adminlte/dist/css/AdminLTE.min.css') }}">

    <link rel="stylesheet" href="{{ jasko_component('/components/adminlte/dist/css/skins/skin-purple-light.min.css') }}">
    <link rel="stylesheet" href="{{ jasko_component('/components/core/css/admin.css') }}">
    @yield( 'styles' )
</head>

<body class="hold-transition skin-purple-light sidebar-mini">
<script>
    var ajaxurl                 =   '{{ url('/admin/') }}/';
</script>
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{ route('admin_dashboard') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>{{ $settings->site_name }}</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>{{ $settings->site_name }}</b> Admin</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </nav>
    </header>
    @include( 'admin.partials.sidebar' )