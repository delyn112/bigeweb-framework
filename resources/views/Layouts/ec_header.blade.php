<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon"  href="<?= assets('images/unnamed.png') ?>">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="web development, framework">
    <meta property="og:image" content="<?= assets('images/unnamed.png') ?>">
    <meta property="og:url" content="<?= url('') ?>">
    <meta name="canonical" content="<?= url('') ?>">
    <link rel="stylesheet" href="<?= assets('/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= assets('/css/app.css') ?>">
    <link rel="stylesheet" href="<?= assets('/css/pkg.css') ?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>