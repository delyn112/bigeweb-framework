<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon"  href="<?= image('images/unnamed.png') ?>">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="web development, framework">
    <meta property="og:image" content="<?= image('images/unnamed.png') ?>">
    <meta property="og:url" content="<?= APP_URL ?>">
    <meta name="canonical" content="<?= APP_URL ?>">
    <link rel="stylesheet" href="<?= APP_URL.'/css/bootstrap.min.css' ?>">
    <link rel="stylesheet" href="<?= APP_URL.'/css/app.css' ?>">
</head>
<body>