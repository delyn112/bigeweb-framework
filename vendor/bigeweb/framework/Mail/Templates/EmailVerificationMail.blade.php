<?php
$title = "Email Verification Request";
require file_path("vendor/bigeweb/framework/Mail/Templates/ec_header.blade.php"); ?>
<div class="container">
    <div class="header">
        <img src="<?= \illuminate\Support\Facades\Config::get('email.logo') ?>" alt="Company Logo">
        <h1>Email Verification Request</h1>
    </div>
    <div class="content">
        <p>Hi <?= $data->username ?>,</p>
        <p>Thank you for registering with us! To complete your registration, please verify your email address.</p>
        <p>Click the button below to verify your email:</p>
        <a href="<?= $verificationLink ?>" class="button">Verify Email</a>
        <p>If you did not create an account, please ignore this email.</p>
        <p>If you have any questions or need assistance, feel free to reach out to our support team.</p>
        <p>Best Regards,<br>The <?= \Illuminate\Support\Facades\Config::get('app.name') ?> Team</p>
    </div>
<?php require file_path("vendor/bigeweb/framework/Mail/Templates/ec_footer.blade.php"); ?>
