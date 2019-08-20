<footer class="footer pb-0 pt-0">
    <div class="footer-main pb-0 mt-0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="logo-footer-wrapper">
                        <div class="logo-footer">
                            <?php
                                echo $this->Html->image('/uploads/images/original/' . $logo, ['alt' => $siteName, 'class' => '']);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="link-wrapper-footer">
                <div class="row">
                    <div class="col-md-5">
                        <span class="title-brown">
                            Want exclusive access to the best<br />
                            wedding industry professionals?
                        </span>
                        <div class="rsvp_form">
                            <input class="rsvp_email" placeholder="Enter your email address" type="text"
                                value="">
                            <input type="button" class="rsvp_button">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <span class="title-brown fw600">
                            ABOUT US
                        </span>
                        <ul>
                            <li><a class="non-uikit" href="#" target="_blank">The Company</a>
                            </li>
                            <li><a class="non-uikit" href="#" target="_blank">Careers</a></li>
                            <li><a class="non-uikit" href="#" target="_blank">Give Back</a></li>
                            <li><a class="non-uikit" href="#" target="_blank">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2">
                        <span class="title-brown sec-fot fw600">
                            NEED HELP?
                        </span>
                        <ul>
                            <li><a class="non-uikit" href="#" target="_blank">How it Works</a>
                            </li>
                            <li><a class="non-uikit" href="#"
                                    target="_blank">Submit a Wedding</a></li>
                            <li><a class="non-uikit" href="#" target="_blank">Vendors</a></li>
                            <li><a class="create-vendor non-uikit" href="#">Create an Account</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <span class="title-brown sec-fot text-uppercase fw600">
                            Contact Us
                        </span>
                        <ul>
                            <li><span class="phone"><a class="non-uikit" href="tel:<?= $themeFunction->purpleSetting('phone')->value ?>"><?= $themeFunction->purpleSetting('phone')->value ?></a></span></li>
                            <li><a class="email non-uikit" href="mailto:<?= $themeFunction->purpleSetting('email')->value ?>"><?= $themeFunction->purpleSetting('email')->value ?></a></li>
                            
                        </ul>
                    </div>
                </div>

                <?php
                    if ($socials->count() > 0):
                ?>
                <div class="divider-footer">
                    <ul class="footer-social">
                        <?php
                            foreach ($socials as $social):
                        ?>
                        <li>
                            <a href="<?= $social->link ?>" target="_blank"><i class="fa fa-<?= $social->name ?>"></i></a>
                        </li>
                        <?php
                            endforeach;
                        ?>
                    </ul>
                </div>
                <?php
                    endif;
                ?>
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                <?php if ($leftFooter == 'NULL') echo ''; else echo $leftFooter ?>
                <?php if ($rightFooter == 'NULL') echo ''; else echo ' <span>|</span> ' . $rightFooter ?>
            </div>
        </div>
    </div>
</footer>