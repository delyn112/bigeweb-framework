<?=  makeView("errors/header") ?>
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
                    <img src="<?= assets('images/mechanic.png') ?>" class="img-fluid" alt="no result">
                </div>
                <div class="title">
                    <h1><?= trans("error.this site is currently under maintenance") ?></h1>
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
<?= makeView("errors/footer") ?>