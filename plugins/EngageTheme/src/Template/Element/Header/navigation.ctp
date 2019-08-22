<header class="header" id="header">
    <div class="header--bottom">
        <div class="container">
            <div class="header--brand">
                <a href="<?= $this->Url->build(['_name' => 'home']); ?>">
                <?php
                    if ($logo == ''):
                        echo $this->Html->image('logo.svg', ['alt' => '', 'class' => 'main-logo']);
                    else:
                        echo $this->Html->image('/uploads/images/original/' . $logo, ['alt' => $siteName, 'class' => '']);
                    endif; 
                ?>
                </a>
            </div>
            <div class="header--burger">
                <a class="mobile-nav-toggle" href="#">
                    <span></span>
                </a>
            </div>


            <div class="header--nav">
                <ul class="navmenu">
                    <li><a href="#" class="non-uikit">TOP VENDORS</a></li>
                    <li>
                        <a href="#" class="non-uikit">VENDORS BY CATEGORY</a>

                        <div class="mega-sub-menu">
                            <div class="inner">
                                <div class="cta-block">
                                    <a href="#">
                                        <img class="cc_header_logo"
                                            src="https://caratsandcake.com/static_home/assets/img/vendor-menu-message.jpg">
                                    </a>
                                </div>
                                <div class="menu-items">
                                    <ul class="mega-sub-menu__items text-left">
                                        <?php
                                            $categories = $themeFunction->frontPageCategories();
                                            if ($categories->count() > 0):
                                                foreach ($categories as $category):
                                                    $categoryUrl = $this->Url->build([
                                                        '_name' => $themeFunction->routePrefix() . 'CategoryDetail',
                                                        'slug'  => $category->slug
                                                    ]);
                                        ?>
                                        <li><a href="<?= $categoryUrl ?>" class="non-uikit"><img class="megamenu-vc" src="<?= $this->Bride->categoryIconConverter($category->icon, 20, '000000') ?>"> <?= $category->name ?></a></li>
                                        <?php
                                                endforeach;
                                            endif;
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li><a href="#" class="non-uikit">BLOGS</a></li>
                    <li><a class="non-uikit link-to-modal-brideme-login" data-brideme-type="vendor" href="#" uk-toggle="target: #modal-brideme-login">ARE YOU A VENDOR?</a></li>
                    
                    <!-- <li class="search-menu-item">
                        <a href="#"><i class="fa fa-search"></i></a>

                        <div class="search-form-submenu">
                        <form method="get">
                            <input type="text" name="s" placeholder="search" />
                        </form>
                        </div>
                    </li> -->
                </ul>
            </div>
            <div class="header-right float-right w-25">
                <ul class="header_actions">
                    <li class="">
                        <a href="#" class="link-to-modal-brideme-login text-black"  data-brideme-type="couple" uk-toggle="target: #modal-brideme-login">
                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="header-currency-divider text-black">|</li>
                    <li class="">
                        <a href="#" class="text-black">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="header-currency-divider text-black">|</li>
                    <?php
                        // Element/Header/currency_lists.ctp
                        echo $this->element('Header/currency_lists'); 
                    ?>
                    <li class="header-currency-divider text-black">|</li>
                    <?php
                        // Element/Header/language_lists.ctp
                        echo $this->element('Header/language_lists'); 
                    ?>
                    <li class="header-currency-divider text-black">|</li>
                    <li><a href="#"class="text-black"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                </ul>       
            </div>
            
            <?php
                // Element/Header/mobile_menu.ctp
                echo $this->element('Header/mobile_menu'); 
            ?>
        </div>
    </div>    
</header>
