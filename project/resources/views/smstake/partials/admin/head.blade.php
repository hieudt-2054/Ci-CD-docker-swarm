<!DOCTYPE html>
<html lang="en">
<head>
    <title>SMSTAKE | @yield('pageTitle') </title>
    <!--Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- site icon or favicon -->
    @include('smstake.partials.admin.template-partials.css')
    @yield('additional-css')
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <script src="{{ asset('smstake/js/jquery-1.11.1.min.js') }}"></script>
</head>
<body>


