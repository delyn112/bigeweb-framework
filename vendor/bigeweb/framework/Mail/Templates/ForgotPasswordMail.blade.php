<?php
    $title = "Password Reset Request";
require file_path("vendor/bigeweb/framework/Mail/Templates/ec_header.blade.php"); ?>
<div class="container">
    <div class="header">
        <img src="<?= \illuminate\Support\Facades\Config::get('email.logo') ?>" alt="Company Logo">
        <h1>Password Reset Request</h1>
    </div>
    <div class="content">
        <p>Hi <?= $data->username ?>,</p>
        <p>We received a request to reset your password. If you didn’t make this request, you can ignore this email.</p>
        <p>To reset your password, please click the button below:</p>
        <a href="<?= $resetLink ?>" class="button">Reset Password</a>
        <p>If you have any questions or need assistance, feel free to reach out to our support team.</p>
        <p>Best Regards,<br>The <?= \illuminate\Support\Facades\Config::get('app.name') ?> Team</p>
    </div>
<?php require file_path("vendor/bigeweb/framework/Mail/Templates/ec_footer.blade.php"); ?>