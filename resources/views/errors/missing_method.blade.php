<?=  makeView("errors/header") ?>
        <div class="product-err-result">
            <div class="container">
                <div class="content-wrapper">
                    <img src="<?= assets("assets/404-error.png") ?>" alt="no-result" class="img-fluid">
                    <div class="text-wrapper">
                        <h1 class="title"><?= trans('error.method not found') ?></h1>
                        <p class="text"><?= $message ?>.
                            <?= trans('error.go back to') ?> <a href="<?= route("home") ?>" style="text-decoration: none; color: #f1586b"><?= trans('error.homepage') ?></a></p>
                    </div>
                </div>
            </div>
        </div>
<?= makeView("errors/footer") ?>