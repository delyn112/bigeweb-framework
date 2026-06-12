<?php
    $title = "Welcome Email";
require file_path("vendor/bigeweb/framework/Mail/Templates/ec_header.blade.php"); ?>
<div class="container">
    <div class="header">
        <img src="<?= \illuminate\Support\Facades\Config::get('email.logo') ?>" alt="Company Logo">
        <h1>Welcome to <?= \illuminate\Support\Facades\Config::get('app.name') ?>!</h1>
    </div>
    <div class="content">
        <p>Hi <?= $data->username ?>,</p>
        <p>Thank you for joining us! We’re thrilled to have you on board.</p>
        <p>Here’s what you can expect:</p>
        <ul>
            <li>Access to exclusive content</li>
            <li>Regular updates and tips</li>
            <li>A supportive community</li>
        </ul>
        <p>If you have any questions or need assistance, feel free to reach out to our support team.</p>
        <p>To get started, you can visit your dashboard:</p>
        <a href="<?= route('login') ?>" class="button">Go to Dashboard</a>
        <p>Best Regards,<br>The <?= \illuminate\Support\Facades\Config::get('app.name') ?> Team</p>
    </div>
<?php require file_path("vendor/bigeweb/framework/Mail/Templates/ec_footer.blade.php"); ?>