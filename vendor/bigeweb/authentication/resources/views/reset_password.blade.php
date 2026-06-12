@extends('Layouts/master')
@section('title', 'Reset your password')
@section('description')
    Forgot your password? reset it now
@endsection
<div class="auth-container">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <form id="data-form">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="title">forgot your password?</h2>
                            <p class="text">Please enter the email address associated with your account and
                                We will email you a link to reset your password.</p>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="action-wrapper-btn button">
                                <div class="wrap-btn">
                                    <button class="btn create-btn" type="button" id="store-data-btn" data-url="<?= route('reset-password') ?>">
                                        reset password</button>
                                    <a href="<?= route('login') ?>" class="link btn">back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="img-wrapper">
                    <img src="<?= assets('images/cloud-scalibility.png') ?>" alt="register" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</div>