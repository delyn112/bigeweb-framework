<?php makeView('Layouts/ec_header'); ?>
<section id="app">
    <?php makeView('Layouts/header');?>
    <section id="main">
       <div class="container">
           <?php makeView('acl::session_alert'); ?>
       </div>
        <?php makeView('acl::alert'); ?>
    @yield('content')
    </section>
    <?php makeView('Layouts/footer');?>
</section>
<?php makeView('Layouts/ec_footer') ?>