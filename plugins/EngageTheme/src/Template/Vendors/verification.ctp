<?php
    echo $this->Form->create($vendorSignUp, [
        'id'                    => 'form-code-verification',
        'class'                 => 'form uk-form-stacked',
        'data-parsley-validate' => '',
        'url'                   => ['_name' => $themeFunction->routePrefix() . 'VendorAjaxVerification']
    ]);
?>
<h3 class="non-uikit mb-4">Verification</h3>
<p class="mb-5">
We've sent the verification code to your email. Insert the verification code below.
</p>

<?php
    echo $this->Form->end();
?>