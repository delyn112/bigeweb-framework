<?php
$title = "Password Changed Successfully";
require file_path("vendor/bigeweb/framework/Mail/Templates/ec_header.blade.php"); ?>

<div class="container">
    <div class="header">
        <img src="<?= \illuminate\Support\Facades\Config::get('email.logo') ?>" alt="Company Logo">
        <h1>Password Changed Successfully</h1>
    </div>
    <div class="content">
        <p>Hi <?= $data->username ?>,</p>
        <p>Your password has been changed successfully. If you didn’t make this change, please contact our support team immediately.</p>
        <p>Thank you for being a part of our community!</p>
        <p>Best Regards,<br>The <?= \illuminate\Support\Facades\Config::get('app.name') ?> Team</p>
    </div>
<?php require file_path("vendor/bigeweb/framework/Mail/Templates/ec_footer.blade.php"); ?>