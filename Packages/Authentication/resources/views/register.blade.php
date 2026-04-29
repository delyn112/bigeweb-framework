@extends('Layouts/master')
@section('title', 'Register')
@section('description')
    Create your account.
@endsection
<div class="auth-container">
    <div class="container">
      <div class="row">
          <div class="col-sm-12 col-md-6 col-lg-6">
              <form id="data-form">
                  <div class="card">
                      <div class="card-header">
                          <h2 class="title"><?= trans('auth::register.register your account') ?></h2>
                          <p class="text"><?= trans('auth::register.welcome! Enter your credentials to get started') ?></p>
                      </div>
                      <div class="card-body">
                          <div class="row g-3 mb-3">
                              <div class="col-sm-12 col-md-6 col-lg-6">
                                  <label for="first_name astar" class="form-label">first name</label>
                                  <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
                              </div>
                              <div class="col-sm-12 col-md-6 col-lg-6">
                                  <label for="last_name" class="form-label astar">last name</label>
                                  <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
                              </div>
                              <div class="col-sm-12 col-md-12 col-lg-12">
                                  <label for="username" class="form-label astar">user name</label>
                                  <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                              </div>
                              <div class="col-sm-12 col-md-12 col-lg-12">
                                  <label for="email" class="form-label">email</label>
                                  <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                              </div>
                              <div class="col-sm-12 col-md-6 col-lg-6">
                                  <label for="password" class="form-label astar">password</label>
                                  <input type="password" class="form-control" name="password" id="password" placeholder="password">
                              </div>
                              <div class="col-sm-12 col-md-6 col-lg-6">
                                  <label for="confirm_password" class="form-label astar">confirm password</label>
                                  <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="confirm password">
                              </div>
                          </div>
                          <input type="text" class="input-hidden" id="usertype" name="usertype" value="user" hidden>
                          <p class="my-text-muted">By Signup, you agree to our <a href="#" class="link">Terms of Service</a> &
                              <a href="#" class="link">Privacy Policy</a></p>
                      </div>
                      <div class="card-footer">
                          <div class="action-wrapper-btn button">
                              <button class="btn create-btn" type="button" id="store-data-btn" data-url="<?= route('register.store') ?>">sign up</button>
                              <p class="text">Have an account? <a href="<?= route('login') ?>" class="link">sign in</a></p>
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
