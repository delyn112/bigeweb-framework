@extends('Layouts/master')
@section('title', 'Login')
@section('description')
    Login to your account.
@endsection
<div class="auth-container">
    <div class="container">
      <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-6">
              <form id="data-form">
                  <div class="card">
                      <div class="card-header">
                          <h2 class="title"><?= trans('auth::login.sign in') ?></h2>
                          <p class="text"><?= trans('auth::login.welcome back! Enter your email or password to get started') ?></p>
                      </div>
                      <div class="card-body">
                          <div class="row g-3 mb-3">
                              <div class="col-sm-12 col-md-12 col-lg-12">
                                  <label for="username" class="form-label astar">username / email</label>
                                  <input type="text" class="form-control" name="username" id="username" placeholder="Email or username" value="<?= \illuminate\Support\Cookies::get('username') ?>">
                              </div>
                              <div class="col-sm-12 col-md-12 col-lg-12">
                                  <label for="password" class="form-label astar">password</label>
                                  <input type="password" class="form-control" name="password" id="password" placeholder="password" value="<?= \illuminate\Support\Cookies::get('password') ?>">
                              </div>
                                  <div class="col-sm-12 col-md-6 col-lg-6">
                                      <div class="form-check">
                                          <input type="checkbox" class="form-check-input" name="remember_me" id="remember_me" value="Yes" <?= \illuminate\Support\Cookies::get('username') != null ? 'checked' : null ?>>
                                          <label for="remember_me" class="form-check-label">remember me</label>
                                      </div>
                                  </div>
                                  <div class="col-sm-12 col-md-6 col-lg-6">
                                      <p class="my-text-muted"> <a href="<?= route('forgot-password') ?>" class="link">Forgot password ?</a></p>
                                  </div>
                          </div>
                      </div>
                      <div class="card-footer">
                          <div class="action-wrapper-btn button">
                              <button class="btn create-btn" type="button" id="store-data-btn" data-url="<?= route('login.store') ?>">sign in</button>
                              <p class="text">Don't have an account? <a href="<?= route('register') ?>" class="link">register</a></p>
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
