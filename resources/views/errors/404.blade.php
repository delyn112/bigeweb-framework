<?=  makeView("errors/header") ?>
        <div class="product-err-result">
            <div class="container">
                <div class="content-wrapper">
                    <img src="<?= assets("images/404-error.png") ?>" alt="no-result.png" class="img-fluid">
                    <div class="text-wrapper">
                        <h1 class="title"><?= trans('error.error 404') ?></h1>
                        <p class="text"><?= trans("error.it seems we can't find what you're looking for") ?>
                           <span><?= trans("error.go back to") ?> <a href="<?= route("home") ?>" style="text-decoration: none; color: #f1586b" class="ms-1"><?= trans("error.homepage") ?></a></span></p>
                    </div>
                </div>
            </div>
        </div>
<?= makeView("errors/footer") ?>