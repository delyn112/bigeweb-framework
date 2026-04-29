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
                            <h2 class="title">change password?</h2>
                            <p class="text">Please your new password in the input field below.</p>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="password" class="form-label astar">password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="password">
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label astar">confirm password</label>
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="confirm password">
                            </div>
                            <input type="number" class="form-control" name="id" id="id" value="<?= $user->id ?>" hidden>
                            <input type="email" class="form-control" name="email" id="email" value="<?= $user->email ?>" hidden>
                        </div>
                        <div class="card-footer">
                            <div class="action-wrapper-btn button">
                                <button class="btn create-btn" type="button" id="store-data-btn" data-url="<?= route('change-password-confirmation') ?>">
                                    change password</button>
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