@extends('Layouts/master')
@section('title', <?= trans("home.welcome to :app", ["app" => \illuminate\Support\Facades\Config::get('app.name')]); ?>)
@section('description')
    Framework from bigeweb
@endsection
<div class="container">
    <div class="img-wrapper">
        <img src="<?= assets('images/New Logo Black.png') ?>" alt="logo" class="img-fluid">
    </div>
    <h1 class="title"><?= trans("home.welcome to :app", ["app" => \illuminate\Support\Facades\Config::get('app.name')]); ?> </h1>
    <div class="content">
        <h3 class="custom-title">
            <?= trans('home.mvc_title', ["app" => \illuminate\Support\Facades\Config::get('app.name')]) ?>.
        </h3>
        <p class="text"><?= trans('home.A full php project developed from scratch This is similar with other mvc project of course, will be slightly different from each other') ?>
        </p>
        <p class="text"><?= trans('home.To proceed with the usage of this project Kindly read its documentation and als the readMe file to learn more about this framework') ?></p>
        <p class="text"><?= trans('home.enjoy coding') ?></p>
    </div>
</div>
