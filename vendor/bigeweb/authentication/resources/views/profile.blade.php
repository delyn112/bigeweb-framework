@extends('Layouts/master')
@section('title', 'profile')
<div class="profile-body-container">
    <form id="data-form" method="POST" class="product-form-data"   enctype="multipart/form-data">
        <div class="product-container article-content">
            <div class="container">
                    <h1 class="page-title">profile</h1>
                    <div class="container-fluid">
                        <div class="custom-content-wrapper">
                            <div class="row g-3">
                                <div class="col-sm-12 col-md-12 col-lg-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="content-header-wrapper">
                                                <img src="<?= assets($user->avatar ?? 'images/istockphoto-1157741177-612x612.jpg') ?>" alt="profile photo" class="img-fluid">
                                                <div class="info-wrap">
                                                    <h1 class="title"><?= $user->firstname.' '.$user->lastname ?></h1>
                                                    <p class="text"> Joined <?= \Carbon\Carbon::parse($user->created_at)->diffForHumans() ?></p>
                                                </div>
                                            </div>
                                            <div class="compensation-wrapper">
                                                <div class="row g-3">
                                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                                        <p class="label">gender</p>
                                                        <p class="value">no data</p>
                                                    </div>
                                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                                        <p class="label">language</p>
                                                        <?php foreach(\Bigeweb\Authentication\Enums\LanguageStatusEnum::cases() as $case) :
                                                        if($case->value == $user->language) : ?>
                                                        <p class="value"><?= $case->name ?></p>
                                                        <?php endif; endforeach; ?>
                                                    </div>
                                                    <div class="col-sm-12 col-md-4 col-lg-4">
                                                        <p class="label">account type</p>
                                                        <p class="value"><?= $user->usertype ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <ul class="content-list">
                                                <li class="flex-item">
                                                    <p class="text-label">Email</p>
                                                    <p class="text-value" style="text-transform: lowercase"><?= $user->email ?></p>
                                                </li>
                                                <li class="flex-item">
                                                    <p class="text-label">mobile</p>
                                                    <p class="text-value"></p>
                                                </li>
                                                <li class="flex-item">
                                                    <p class="text-label">status</p>
                                                    <?php foreach(\Bigeweb\Authentication\Enums\RegisterStatusEnum::cases() as $case) :
                                                    if($case->value == $user->status) : ?>
                                                    <p class="text-value status-px-2"><?= $case->name ?></p>
                                                    <?php endif; endforeach; ?>
                                                </li>
                                            </ul>
                                            <address class="address">
                                                <span class="text-danger me-2"><i class="fa-solid fa-location-dot"></i></span>Location:<br>
                                            </address>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card profile-card">
                                <div class="card-header">
                                    <h1 class="title">personal information</h1>
                                </div>
                                <div class="card-body">
                                    <form class="profile-form">
                                        <input type="text" id="id" name="id" value="<?= $user->id?>" hidden>
                                        <div class="row g-1 mb-3">
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="mb-2">
                                                    <label for="first_name" class="form-label astar">first name</label>
                                                    <input type="text" class="form-control" name="first_name" id="first_name" value="<?= $user->firstname ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="mb-2">
                                                    <label for="last_name" class="form-label astar">last name</label>
                                                    <input type="text" class="form-control" name="last_name" id="last_name" value="<?= $user->lastname ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-5 col-lg-5">
                                                <div class="mb-2">
                                                    <label for="username" class="form-label astar">username</label>
                                                    <input type="text" class="form-control" name="username" id="username" value="<?= $user->username ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-7 col-lg-7">
                                                <div class="mb-2">
                                                    <label for="email" class="form-label astar">email</label>
                                                    <input type="email" class="form-control" name="email" id="email" value="<?= $user->email ?>" disabled>
                                                </div>
                                            </div>
                                        </div>
                                      <div class="row g-3">
                                          <div class="col-sm-12 col-md-6 col lg-6">
                                              <div class="mb-2 fl-wrapper">
                                                  <div class="container-fluid p-0">
                                                      <label for="profile-photo" class="form-label">profile photo</label>
                                                      <div class="thumbnail-element">
                                                          <div class="thumbnail-preview-content <?= $user->avatar ? 'active' : null; ?>">
                                                              <div class="element" id="removeable">
                                                                  <span class="rm-button remove-current-img"><i class="fa-solid fa-xmark"></i></span>
                                                                  <span class="text">pics.jpg</span>
                                                                  <input type="text" class="form-control" name="old_photo" id="old_photo" value="<?= $user->avatar ?>" hidden="">
                                                                   <img src="<?= assets($user->avatar) ?>" alt="profile photo" class="img-fluid">
                                                              </div>
                                                          </div>
                                                          <div class="upload-wrapper">
                                                              <div class="thumbnail-wrapper">
                                                                  <span class="icon"><i class="fa-solid fa-camera"></i></span>
                                                                  <input type="file" class="form-control photo-uploader" name="photo"  id="photo" accept="image/*">
                                                                  <p class="text">photo</p>
                                                              </div>
                                                          </div>
                                                          <div class="error-text">Only images are allowed. Please upload png, jpeg or jpg.</div>
                                                          <div class="error-text">Please upload a video with format avi or mp4.</div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                        <div class="mb-2 mt-3 wrapper">
                                            <div class="form-check form-switch mb-3">
                                                <input type="checkbox" class="form-check-input" id="change-password" role="switch" name="change-password" onchange="showPasswordBox(this)" value="on">
                                                <label for="change-password" class="form-check-label">change password</label>
                                            </div>
                                            <div class="password-content-wrapper">
                                               <div class="row g-3">
                                                   <div class="col-sm-12 col-md-6 col-lg-6">
                                                       <div class="mb-3">
                                                           <label for="current_password" class="form-label astar">current password</label>
                                                           <input type="password" class="form-control" name="current_password" id="current_password" placeholder="password">
                                                       </div>
                                                       <div class="mb-3">
                                                           <label for="password" class="form-label astar">new password</label>
                                                           <input type="password" class="form-control" name="password" id="password" placeholder="confirm password">
                                                       </div>
                                                       <div class="mb-3">
                                                           <label for="confirm_password" class="form-label astar">confirm password</label>
                                                           <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="confirm password">
                                                       </div>
                                                   </div>
                                               </div>
                                            </div>
                                        </div>
                                        <div class="button mt-5 mb-5">
                                            <button class="btn create-btn data-btn" type="submit" id="store-data-btn"
                                                    data-url="<?= route('store-profile') ?>">
                                                <span class="loading-icon spinner"><i class="fa-solid fa-spinner"></i></span>
                                                <span class="btn-text">save changes
                                                <span class="ms-2"><i class="fa-solid fa-chevron-right"></i></span></span>
                                                <span class="loading-text">please wait...</span>
                                            </button>
                                        </div>
                                    </form>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>