<section id="header">
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="nav-brand">
                    <a href="<?= route('home') ?>" class="link mybrand"><?= \illuminate\Support\Facades\Config::get('app.name') ?></a>
                    <button class="btn toggle-media-btn" onclick="open_menu_header(event, this)">
                        <span class="icon"><i class="fa-solid fa-bars"></i></span>
                    </button>
                </div>
                <div class="menu-container">
                    <ul class="menu-wrapper">
                        <li class="item">
                            <a href="<?= route('home') ?>" class="link active">home</a>
                        </li>
                        <li class="item">
                            <a href="#" class="link">services</a>
                        </li>
                        <li class="item">
                            <a href="#" class="link">about</a>
                        </li>
                        <li class="item">
                            <a href="#" class="link">contact us</a>
                        </li>
                    </ul>
                    <ul class="menu-wrapper">
                        <?php  if(!\Bigeweb\Authentication\Facades\Authcheck::user()) : ?>
                        <li class="item">
                            <a href="<?= route('register') ?>" class="link">
                                <span class="icon"><i class="fa-solid fa-user"></i></span>
                                sign up</a>
                        </li>
                        <li class="item">
                            <a href="<?= route('login') ?>" class="link">login</a>
                        </li>
                        <?php else : ?>
                        <li class="item dropdown">
                            <button class="dropdown-btn">
                                <span class="icon"><i class="fa-solid fa-circle-user"></i></span>
                                my account
                            </button>
                            <ul class="dropdown-content">
                              <li class="dropdown-item">
                                  <a href="<?= route('profile-manager', [
                                            'userid' => \Bigeweb\Authentication\Facades\Auth::user()->id,
                                            'token' => \Bigeweb\Authentication\Facades\Auth::user()->token,
                                    ]) ?>" class="link">
                                      <span class="icon"><i class="fa-solid fa-user"></i></span>profile</a>
                              </li>
                              <li class="dropdown-item">
                                  <a href="<?= route('logout') ?>" class="link">
                                      <span class="icon"><i class="fa-solid fa-right-from-bracket"></i></span>logout</a>
                              </li>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>