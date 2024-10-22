@extends('Layouts/master')
@section('title', <?= 'Welcome to '.\illuminate\Support\Facades\Config::get('app.name') ?>)
@section('description', 'Framework from bigeweb')
<section id="header">
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
               <div class="nav-brand">
                   <a href="#" class="link mybrand"><?= \illuminate\Support\Facades\Config::get('app.name') ?></a>
                   <button class="btn toggle-media-btn" onclick="open_menu_header(event, this)">
                       <span class="icon"><i class="fa-solid fa-bars"></i></span>
                   </button>
               </div>
               <div class="menu-container">
                   <ul class="menu-wrapper">
                       <li class="item">
                           <a href="#" class="link active">home</a>
                       </li>
                       <li class="item">
                           <a href="#" class="link">services</a>
                       </li>
                       <li class="item">
                           <a href="#" class="link">about</a>
                       </li>
                       <li class="item">
                           <a href="#" class="link">contact us</a>
                       </li>
                   </ul>
                   <ul class="menu-wrapper">
                       <li class="item">
                           <a href="#" class="link">
                               <span class="icon"><i class="fa-solid fa-user"></i></span>
                               sign up</a>
                       </li>
                       <li class="item">
                           <a href="#" class="link">login</a>
                       </li>
                   </ul>
               </div>
            </div>
        </div>
    </div>
</section>
<section id="main">
    <div class="container">
        <div class="img-wrapper">
            <img src="<?= assets('images/New Logo Black.png') ?>" alt="logo" class="img-fluid">
        </div>
        <h1 class="title">Welcome to <?= \illuminate\Support\Facades\Config::get('app.name') ?></h1>
        <div class="content">
            <h3 class="custom-title">
                Model, View And Controller (MVC) by <?= \illuminate\Support\Facades\Config::get('app.name') ?>.
            </h3>
            <p class="text">A full php project developed from scratch.
                This is similar with other mvc project. of course,
                will be slightly different from each other.
            </p>
            <p class="text">To proceed with the usage of this project. Kindly read its documentation and als the
            readMe file to learn more about this framework.</p>
            <p class="text">Enjoy coding!!!</p>
        </div>
    </div>
</section>
<section id="footer">
    <div class="container">
        <p class="text">Copyright &copy; of <?= \illuminate\Support\Facades\Config::get('app.name') ?> <?= date("Y") ?>.</p>
    </div>
</section>