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
                    <?php 
                        if ($userData == NULL):
                    ?>
                    <li><a class="non-uikit link-to-modal-brideme-vendor-login" data-brideme-type="vendor" href="#" uk-toggle="target: #modal-brideme-vendor-login">ARE YOU A VENDOR?</a></li>
                    <?php
                        endif;
                    ?>
                    
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
                        <a href="#" class="<?php if ($userData == NULL): ?>link-to-modal-brideme-couples-login<?php endif; ?> text-black" <?php if ($userData == NULL): ?>uk-toggle="target: #modal-brideme-couples-login"<?php endif; ?>>
                            <?php if ($userData != NULL) echo $userData->full_name ?> <?php if ($userData == NULL): ?><i class="fa fa-unlock-alt" aria-hidden="true"></i><?php endif; ?>
                        </a>

                        <?php if ($userData != NULL): ?>
                        <?php
                            if ($userType == 'vendor') {
                                $logOutUrl = $this->Url->build([
                                    '_name'  => $themeFunction->routePrefix() . 'VendorDashboardAction',
                                    'action' => 'logout'
                                ]);
                            }
                        ?>
                        <div class="" uk-dropdown="mode: click; offset: 16;">
                            <ul class="uk-nav uk-dropdown-nav bridestiny-signed-in-dropdown">
                                <li class="">
                                    <div class="uk-grid-small uk-flex-middle" uk-grid>
                                        <div class="uk-width-auto">
                                            <img class="<?php if ($userData->photo == NULL) echo 'initial-photo'; ?> uk-border-circle" width="40" height="40" <?php if ($userData->photo != NULL): ?>src="<?= $this->request->getAttribute("webroot") . 'uploads/images/original/' . $userData->photo ?>"<?php endif; ?> data-height="40" data-width="40" data-char-count="2" data-font-size="20" data-name="<?= $userData->full_name ?>">
                                        </div>
                                        <div class="uk-width-expand">
                                            <h5 class="uk-card-title uk-margin-remove-bottom"><?= $userData->full_name ?></h5>
                                            <p class="uk-text-meta uk-margin-remove-top"><small><?= $userData->bride_type ?></small></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="p-0 ml-0" style=""><a class="non-uikit text-black" href="#">Dashboard</a></li>
                                <li class="p-0 ml-0"><a class="non-uikit text-black" href="<?= $logOutUrl ?>">Logout</a></li>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </li>
                    <?php 
                        if ($userData == NULL || ($userData != NULL && $userType == 'customer')):
                    ?>
                    <li class="header-currency-divider text-black">|</li>
                    <li class="">
                        <a href="#" class="text-black">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </a>
                    </li>
                    <?php
                        endif;
                    ?>
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
