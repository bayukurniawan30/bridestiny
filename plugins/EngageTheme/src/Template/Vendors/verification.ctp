<?php
    $submitRedirect = $this->Url->build([
        '_name'  => $themeFunction->routePrefix() . 'VendorPendingAccount'
    ]);

    echo $this->Form->create($vendorCodeVerification, [
        'id'                    => 'form-verification-code',
        'class'                 => 'form uk-form-stacked',
        'data-parsley-validate' => '',
        'url'                   => ['_name' => $themeFunction->routePrefix() . 'VendorAjaxVerification']
    ]);

    echo $this->Form->hidden('ds', ['value' => $this->Url->build(['_name' => $themeFunction->routePrefix() . 'VendorViewDetail', 'id' => $sessionVendorId])])
?>
<h3 class="non-uikit mb-4">Verification</h3>
<p class="mb-5">
We've sent the verification code to your email. Insert the verification code below.
</p>

<div class="row">
    <div class="col-md-12">
        <div class="" uk-grid>
            <div class="uk-margin-small uk-width-1-1">
                <label class="uk-form-label" for="form-stacked-name">Verification Code</label>
                <div class="uk-form-controls">
                    <?php
                        echo $this->Form->text('code', [
                            'id'                     => 'form-stacked-name',
                            'class'                  => 'uk-input',
                            'placeholder'            => '6 digits verification code',
                            'data-parsley-minlength' => '6',
                            'data-parsley-maxlength' => '6',
                            'data-parsley-type'      => 'number',
                            'autofocus'              => 'autofocus',
                            'required'               => 'required'
                        ]);
                    ?>
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
    <div class="col-md-8 offset-md-2 uk-margin-large-top">
        <?php
            echo $this->Form->button('Verify', [
                'id'    => 'button-verification-code',
                'class' => 'btn btn-primary btn-block'
            ]);
        ?>
        <p class="text-center"><a class="non-uikit" href="#">Didn't receive the email? Resend code</a></p>
    </div>
</div>

<?php
    echo $this->Form->end();
?>

<script>
    $(document).ready(function() {
        var t = "form-verification-code",
            n = "Bridestiny.signUp",
            o = "redirect",
            a = "<?= $submitRedirect ?>",
            c = "Verify",
            r = "Processing...";
        $("#button-verification-code").one("click",function(){ajaxSubmit(t,n,o,a,c,r)})
    })
</script>