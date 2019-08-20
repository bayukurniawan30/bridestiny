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
                                    <a href="#lol">
                                        <img class="cc_header_logo"
                                            src="https://caratsandcake.com/static_home/assets/img/vendor-menu-message.jpg">
                                    </a>
                                </div>
                                <div class="menu-items">
                                    <ul class="mega-sub-menu__items text-left">
                                        
                                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/20/000000/pavilion.png"> Venue</a></li>
                                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/20/000000/screenshot.png"> Photographers</a></li>
                                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/20/000000/video-call.png"> Videographer</a></li>
                                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/20/000000/kokoshnik.png"> Make-up and hair-do</a></li>
                                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/20/000000/wedding-dress.png"> Bridal </a></li>
                                        
                                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/20/000000/tableware.png"> Catering</a>
                                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/20/000000/bunch-flowers.png"> Flowers & decoration</a></li>
                                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/20/000000/wedding-gift.png"> Favor & gifts</a></li>
                                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/20/000000/technical-support.png"> Officiant</a></li>
                                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/20/000000/documentary.png"> Entertainment </a></li>
                                            
                                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/20/000000/selfie-booth.png"> Photo booth</a></li>                                                
                                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/20/000000/wedding-cake.png"> Wedding Cake</a></li>
                                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/20/000000/invitation.png"> Invitation</a></li>
                                        <li><a href="#" class="non-uikit"><img class="megamenu-vc" src="https://img.icons8.com/ios/20/000000/overtime.png"> Weddings Planner</a></li>
                                    
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
