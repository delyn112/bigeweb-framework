<?=  makeView("errors/header") ?>
        <div class="product-err-result">
            <div class="container">
                <div class="content-wrapper">
                    <img src="<?= assets("images/no-result.png") ?>" alt="no-result.png" class="img-fluid">
                    <div class="text-wrapper">
                        <h1 class="title">Error 404</h1>
                        <p class="text">It seems we can't find what you're looking for.
                            go back to <a href="<?= route("home") ?>" style="text-decoration: none; color: #f1586b">homepage</a></p>
                    </div>
                </div>
            </div>
        </div>
<?= makeView("errors/footer") ?>