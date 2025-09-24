<?php
$title = "Email Verified Successfully";
require file_path("vendor/bigeweb/framework/Mail/Templates/ec_header.blade.php"); ?>
<div class="container">
    <div class="header">
        <img src="<?= \illuminate\Support\Facades\Config::get('email.logo') ?>" alt="Company Logo">
        <h1>Email Verified Successfully</h1>
    </div>
    <div class="content">
        <p>Hi <?= $data->username ?>,</p>
        <p>Congratulations! Your email address <strong><?= $data->email ?></strong> has been successfully verified.</p>
        <p>You can now enjoy all the features of your account. If you have any questions or need assistance, feel free to reach out to our support team.</p>
        <p>Thank you for being a part of our community!</p>
        <p>Best Regards,<br>The <?= \Illuminate\Support\Facades\Config::get('app.name') ?> Team</p>
    </div>
<?php require file_path("vendor/bigeweb/framework/Mail/Templates/ec_footer.blade.php"); ?>
