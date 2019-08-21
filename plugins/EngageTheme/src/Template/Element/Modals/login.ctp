<?php
    $signUpVendorUrl = $this->Url->build([
        '_name'  => $themeFunction->routePrefix() . 'VendorSignUp'
    ]);

    $signUpCustomerUrl = $this->Url->build([
        '_name'  => $themeFunction->routePrefix() . 'CustomerSignUp'
    ]);
?>
<div id="modal-brideme-login" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical uk-modal-body uk-padding-remove">
        <button class="uk-modal-close-outside" type="button" uk-close></button>

        <ul class="brideme-login-tab" uk-tab>
            <li class="brideme-login-tab-couples"><a href="#" class="non-uikit">Couples</a></li>
            <li class="brideme-login-tab-vendors"><a href="#" class="non-uikit">Vendors</a></li>
        </ul>

        <ul id="switcher-brideme-login" class="uk-switcher uk-margin uk-margin-remove-top uk-margin-remove-bottom">
            <li class="uk-padding brideme-couples-login">
                <div class="row uk-flex uk-flex-middle">
                    <div class="col-md-6 text-center">
                        <h3 class="non-uikit vendor-login-main-title">Join The Best of<br>The Wedding Industry</h3>

                        <p class="vendor-login-description">Become a member and find the best vendors for your wedding.</p>
                    </div>
                    <div class="col-md-6 vendor-login-form uk-padding-remove-right">
                        <p class="member-login-text text-center">Couple Login</p>

                        <form id="form-couple-login" method="post" action="" data-parsley-validate>
                            <fieldset class="uk-fieldset">
                                <div class="uk-margin">
                                    <input class="uk-input" type="email" placeholder="Enter your email address" name="email" required>
                                </div>
                                <div class="uk-margin">
                                    <input class="uk-input" type="password" placeholder="Enter your password" name="password" required>
                                </div>
                                <div class="uk-margin">
                                    <button class="uk-button button-vendor-login uk-width-1-1" type="submit">Login <i class="fa fa-angle-right"></i></button>
                                </div>
                                <div class="uk-margin text-center">
                                    <a href="<?= $signUpCustomerUrl ?>" onclick="window.location.href='<?= $signUpCustomerUrl ?>'" class="non-uikit create-new-account-link">Or create new account</a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </li>
            <li class="uk-padding brideme-vendor-login">
                <div class="row uk-flex uk-flex-middle">
                    <div class="col-md-6 text-center">
                        <h3 class="non-uikit vendor-login-main-title">Join The Best of<br>The Wedding Industry</h3>

                        <p class="vendor-login-description">Become a member today to get access to your custom profile and our exclusive business insights</p>
                    </div>
                    <div class="col-md-6 vendor-login-form uk-padding-remove-right">
                        <p class="member-login-text text-center">Vendor Login</p>

                        <form id="form-vendor-login" method="post" action="" data-parsley-validate>
                            <fieldset class="uk-fieldset">
                                <div class="uk-margin">
                                    <input class="uk-input" type="email" placeholder="Enter your email address" name="email" required>
                                </div>
                                <div class="uk-margin">
                                    <input class="uk-input" type="password" placeholder="Enter your password" name="password" required>
                                </div>
                                <div class="uk-margin">
                                    <button class="uk-button button-vendor-login uk-width-1-1"  type="submit">Login <i class="fa fa-angle-right"></i></button>
                                </div>
                                <div class="uk-margin text-center">
                                    <a href="<?= $signUpVendorUrl ?>" onclick="window.location.href='<?= $signUpVendorUrl ?>'" class="non-uikit create-new-account-link">Or create new account</a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </li>
        </ul>

        <div class="uk-modal-footer uk-text-center">
            <strong>Question?</strong> <a href="tel:+62361777888" class="non-uikit"><?= $themeFunction->purpleSetting('phone')->value ?></a> | <a href="mailto:<?= $themeFunction->purpleSetting('email')->value ?>" class="non-uikit"><?= $themeFunction->purpleSetting('email')->value ?></a>
        </div>
    </div>
</div>