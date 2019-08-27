<div class="header--mobile-menu">
        <div class="inner">
            <div class="mobile-menu-heading">
                <a href="<?= $this->Url->build(['_name' => 'home']); ?>">
                    <?php
                        if ($logo == ''):
                            echo $this->Html->image('logo.svg', ['alt' => '', 'class' => 'logo-mobile']);
                        else:
                            echo $this->Html->image('/uploads/images/original/' . $logo, ['alt' => $siteName, 'class' => 'logo-mobile']);
                        endif; 
                    ?>
                </a>
                <a class="close-this" href="#"><i class="fa fa-times-circle"></i></a>
            </div>

            <ul class="navmenu" data-aos="fade-in">
                <li><a href="#" class="non-uikit">TOP VENDORS</a></li>
                <li>
                    <a href="#" class="non-uikit">VENDORS BY CATEGORY</a>

                    <ul class="sub mega-menu-mobile">
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
                </li>
                <li><a href="#" class="non-uikit">BLOGS</a></li>
                <?php 
                    if ($userData == NULL):
                ?>
                <li style="clear: both"><a href="#" class="non-uikit link-to-modal-brideme-vendor-login" data-brideme-type="vendor" href="#" uk-toggle="target: #modal-brideme-vendor-login">ARE YOU A VENDOR?</a></li>
                <?php
                    endif;
                ?>

                <?php if ($userData != NULL): ?>
                <?php
                    if ($userType == 'vendor') {
                        $dashboardUrl = $this->Url->build([
                            '_name'  => $themeFunction->routePrefix() . 'VendorDashboard'
                        ]);

                        $logOutUrl = $this->Url->build([
                            '_name'  => $themeFunction->routePrefix() . 'VendorDashboardAction',
                            'action' => 'logout'
                        ]);
                    }
                ?>
                <li><a href="<?= $dashboardUrl ?>" class="non-uikit link-to-modal-brideme-couples-login" data-brideme-type="couples" uk-toggle="target: #modal-brideme-couples-login"><span class="login-wedding-descmobile"><i class="fa fa-dashboard"></i> <?= $userData->full_name ?></span></a></li>

                <li><a href="<?= $logOutUrl ?>" class="non-uikit"><span class="login-wedding-descmobile"><i class="fa fa-sign-out"></i> Logout</span></a></li>                
                <?php
                    else:
                ?>
                <li><a href="#" class="non-uikit link-to-modal-brideme-couples-login" data-brideme-type="couples" uk-toggle="target: #modal-brideme-couples-login"><span class="login-wedding-descmobile">Login</span></a></li>

                <?php
                    endif;
                ?>

                <?php 
                    if ($userData == NULL || ($userData != NULL && $userType == 'customer')):
                ?>
                <li><a href="#" class="non-uikit"><span class="login-wedding-descmobile">Cart</span></a></li>
                <?php
                    endif;
                ?>
                <!-- <li>
                    <form class="mobile-search-form" method="get">
                        <input type="text" name="s" placeholder="SEARCH" />
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </li> -->
            </ul>
        </div>
    </div>