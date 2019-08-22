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
                <li style="clear: both"><a href="#" class="non-uikit">ARE YOU A VENDOR?</a></li>
                <li><a href="#" class="non-uikit link-to-modal-brideme-login" data-brideme-type="couple" uk-toggle="target: #modal-brideme-login"><span class="login-wedding-descmobile">Login</span></a></li>
                <li><a href="#" class="non-uikit"><span class="login-wedding-descmobile">Cart</span></a></li>
                <!-- <li>
                    <form class="mobile-search-form" method="get">
                        <input type="text" name="s" placeholder="SEARCH" />
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </li> -->
            </ul>
        </div>
    </div>