<div class="container-fluid">
    <?php if(\illuminate\Support\Session::get('success')) : ?>
    <div class="alert alert-success show text-center">
        <li> <?=  \illuminate\Support\Session::get('success') ?></li>
    </div>
    <?php elseif(\illuminate\Support\Session::get('danger')) : ?>
    <div class="alert alert-danger show text-center">
        <li><?=  \illuminate\Support\Session::get('danger') ?></li>
    </div>
    <?php elseif(\illuminate\Support\Session::get('warning')) : ?>
    <div class="alert alert-warning show text-center">
        <li><?=  \illuminate\Support\Session::get('warning') ?></li>
    </div>
    <?php endif; ?>
</div>