<?php
    $signUpVendorUrl = $this->Url->build([
        '_name'  => $themeFunction->routePrefix() . 'VendorSignUp'
    ]);
    
    $signInRedirect = $this->Url->build([
        '_name'  => $themeFunction->routePrefix() . 'VendorDashboard'
    ]);
?>
<div id="modal-brideme-vendor-login" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical uk-modal-body uk-padding-remove">
        <button class="uk-modal-close-outside" type="button" uk-close></button>
        <div class="row uk-flex uk-flex-middle uk-padding">
            <div class="col-md-6 text-center">
                <h3 class="non-uikit vendor-login-main-title">Join The Best of<br>The Wedding Industry</h3>
                <p class="vendor-login-description">Become a member today to get access to your custom profile and our exclusive business insights</p>
            </div>
            <div class="col-md-6 vendor-login-form uk-padding-remove-right">
                <p class="member-login-text text-center">Vendor Login</p>

                <?php
                    echo $this->Form->create($vendorSignIn, [
                        'id'                    => 'form-vendor-signin',
                        'data-parsley-validate' => '',
                        'url'                   => ['_name' => $themeFunction->routePrefix() . 'VendorAjaxSignIn']
                    ]);

                    echo $this->Form->hidden('user_signin_type', ['value' => 'vendor']);
                ?>
                <fieldset class="uk-fieldset">
                    <div class="uk-margin">
                        <?php
                            echo $this->Form->text('email', [
                                'type'                   => 'email',
                                'class'                  => 'uk-input',
                                'placeholder'            => 'Enter your email address ',
                                'data-parsley-type'      => 'email',
                                'required'               => 'required'
                            ]);
                        ?>
                    </div>
                    <div class="uk-margin">
                        <?php
                            echo $this->Form->password('password', [
                                'class'                  => 'uk-input', 
                                'placeholder'            => 'Password. 6 -20 characters',
                                'data-parsley-minlength' => '6',
                                'data-parsley-maxlength' => '20',
                                'autocomplete' 			 => '',
                                'required'               => 'required'
                            ]);
                        ?>
                    </div>
                    <div class="uk-margin">
                        <?php
                            echo $this->Form->button('Sign In <i class="fa fa-angle-right"></i>', [
                                'id'    => 'button-vendor-signin',
                                'class' => 'uk-button button-vendor-login uk-width-1-1',
                                'data-purple-error-container' => '#modal-signin-result',
                                'data-purple-url' => $signInRedirect
                            ]);
                        ?>
                    </div>
                    <div class="uk-margin"><div id="modal-signin-result"></div></div>

                    <div class="uk-margin text-center">
                        <a href="<?= $signUpVendorUrl ?>" onclick="window.location.href='<?= $signUpVendorUrl ?>'" class="non-uikit create-new-account-link">Or create new account</a>
                    </div>
                </fieldset>
                <?php
                    echo $this->Form->end();
                ?>
            </div>
        </div>

        <div class="uk-modal-footer uk-text-center">
            <strong>Question?</strong> <a href="tel:+62361777888" class="non-uikit"><?= $themeFunction->purpleSetting('phone')->value ?></a> | <a href="mailto:<?= $themeFunction->purpleSetting('email')->value ?>" class="non-uikit"><?= $themeFunction->purpleSetting('email')->value ?></a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var t = "form-vendor-signin",
            n = "Bridestiny.signIn",
            o = "redirect",
            a = $("#button-vendor-signin").attr('data-purple-url'),
            c = "Sign In",
            r = "Processing...";
        $("#button-vendor-signin").one("click",function(){ajaxSubmit(t,n,o,a,c,r)})
    })
</script>