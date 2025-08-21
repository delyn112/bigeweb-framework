<?=  makeView("errors/header") ?>
        <div class="product-err-result">
            <div class="container">
                <div class="content-wrapper">
                    <img src="<?= assets("assets/404-error.png") ?>" alt="no-result" class="img-fluid">
                    <div class="text-wrapper">
                        <h1 class="title">Method not found.</h1>
                        <p class="text"><?= $message ?>.
                            go back to <a href="<?= route("home") ?>" style="text-decoration: none; color: #f1586b">homepage</a></p>
                    </div>
                </div>
            </div>
        </div>
<?= makeView("errors/footer") ?>