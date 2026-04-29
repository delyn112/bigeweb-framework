@extends('Layouts/master')
@section('title', 'Verify your email')
@section('description')
    Email verification required
@endsection
<div class="auth-container">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <form id="data-form">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="title">Verify your email</h2>
                            <p>A verification email has been sent to your email address <strong><?= \Bigeweb\Authentication\Facades\Auth::user()->email ?></strong>.</p>
                            <p>Please check your inbox and click on the link to verify your email.</p>
                            <p>If you didn't receive the email, you can click the button below to resend the verification link:</p>
                        </div>
                        <div class="card-footer">
                            <div class="action-wrapper-btn button">
                                <div class="wrap-btn">
                                    <a class="btn create-btn" href="<?= route('resend-verification-link') ?>">
                                        Resend Verification Link</a>
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