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
                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/screenshot.png"> Photographers</a>
                        </li>
                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/wedding-dress.png"> Wedding Dresses</a></li>
                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/women-shoe-side-view.png"> Shoes</a></li>
                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/pavilion.png"> Venue</a></li>

                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/bunch-flowers.png"> Flowers</a></li>
                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/wedding-cake.png"> Cake</a></li>
                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/tableware.png"> Catering</a>
                        </li>
                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/slip-dress.png"> Bridesmaid Dresses</a>
                        </li>

                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/kokoshnik.png"> Hair Accessories</a></li>
                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/ring-side-view.png"> Rings</a></li>
                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/hair-dryer.png"> HairItem</a></li>
                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/groom.png"> Groom</a>
                        </li>

                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/stationery.png"> Stationery</a></li>
                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/overtime.png"> Weddings Planner</a></li>
                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/documentary.png"> Cinematographer</a></li>
                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/18/000000/musical-notes.png"> Music</a></li>
                    </ul>
                </li>
                <li><a href="#" class="non-uikit">BLOGS</a></li>
                <li style="clear: both"><a href="#" class="non-uikit">ARE YOU A VENDOR?</a></li>
                <li><a href="#" class="non-uikit"><span class="login-wedding-descmobile">Login</span></a></li>
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