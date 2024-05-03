<!DOCTYPE html>
<html lang="en" style="background-color: #7020ab !important">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System is under maintenance</title>
    <link rel="stylesheet" href="<?= APP_URL ?>/css/maintenance.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body style="background-color: #7020ab !important">

<section id="maintenance">
    <div class="body-container">
        <div class="background">
            <div class="icon1">
                <i class="fa-solid fa-gear"></i>
            </div>
            <div class="icon2">
                <i class="fa-solid fa-gear"></i>
            </div>
        </div>
        <div class="foreground">
            <div class="content-wrapper">
                <div class="image">
                    <img src="<?= image('assets/road-block.png') ?>" class="img-fluid" alt="">
                </div>
                <div class="title">
                    <h1>This site is currently under maintenance.</h1>
                </div>
                <div class="lines">
                    <div class="line1"></div>
                    <div class="line2"></div>
                </div>
                <div class="description">
                    <div class="desc-wrapper">
                            <h5><?= $site_mode->message ?></h5>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://kit.fontawesome.com/f71b1acd80.js" crossorigin="anonymous"></script>
</body>
</html>