<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SeoGram - SEO Agency Template</title>
    <link rel="stylesheet" href="{{ asset('assets/css/maicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <script type="text/javascript"  src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
    <script type="text/javascript">
        var base_url = '{{ url("/") }}/';
        var is_host = 0;
    </script>
</head>
<body>
