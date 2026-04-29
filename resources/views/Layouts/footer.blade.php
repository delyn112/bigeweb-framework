<section id="footer">
    <div class="container">
        <p class="text"><?= trans('home.copyright of', ["app" => \illuminate\Support\Facades\Config::get('app.name'),
                "date" => date("Y")]) ?></p>
    </div>
</section>