<?php
    $submitRedirect = $this->Url->build([
        '_name'  => $themeFunction->routePrefix() . 'VendorDashboard'
    ]);

    $signUpUrl = $this->Url->build([
        '_name'  => $themeFunction->routePrefix() . 'VendorSignUp'
    ]);

    echo $this->Form->create($vendorSignIn, [
        'id'                    => 'form-sign-in',
        'class'                 => 'form uk-form-stacked',
        'data-parsley-validate' => '',
        'url'                   => ['_name' => $themeFunction->routePrefix() . 'VendorAjaxSignIn']
    ]);
?>
<h3 class="non-uikit mb-4">Sign In</h3>
<p class="mb-5">
Sign In to manage your packages, orders, and portfolios.
</p>
<div class="nano sign-in-form">
    <div class="nano-content">
        <div class="row">
            <div class="col-md-12">
                <div class="" uk-grid>
                    <div class="uk-margin-small uk-width-1-1">
                        <label class="uk-form-label" for="form-stacked-email">Email<span class="required-form-label">*</span></label>
                        <div class="uk-form-controls">
                            <?php
                                echo $this->Form->text('email', [
                                    'type'                   => 'email',
                                    'id'                     => 'form-stacked-email',
                                    'class'                  => 'uk-input',
                                    'placeholder'            => 'Enter your email address',
                                    'data-parsley-type'      => 'email',
                                    'required'               => 'required'
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="uk-margin-small uk-width-1-1">
                        <label class="uk-form-label" for="form-stacked-password">Password<span class="required-form-label">*</span></label>
                        <div class="uk-form-controls">
                            <?php
                                echo $this->Form->password('password', [
                                    'id'                     => 'form-stacked-password',
                                    'class'                  => 'uk-input', 
                                    'placeholder'            => 'Password. 6 -20 characters',
                                    'data-parsley-minlength' => '6',
                                    'data-parsley-maxlength' => '20',
                                    'autocomplete' 			 => '',
                                    'required'               => 'required'
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 uk-margin-top">
        <div id="error-result"></div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 offset-md-2 uk-margin-top">
        <?php
            echo $this->Form->button('Sign In', [
                'id'    => 'button-sign-in',
                'class' => 'btn btn-primary btn-block',
            ]);
        ?>
        <p class="text-center"><a class="non-uikit" href="<?= $signUpUrl ?>">Don't have an account yet? Sign Up now</a></p>
    </div>
</div>
<?php
    echo $this->Form->end();
?>

<script>
    $(document).ready(function() {
        var t = "form-sign-in",
            n = "Bridestiny.signIn",
            o = "redirect",
            a = "<?= $submitRedirect ?>",
            c = "Sign In",
            r = "Processing...";
        $("#button-sign-in").one("click",function(){ajaxSubmit(t,n,o,a,c,r)})
    })
</script>