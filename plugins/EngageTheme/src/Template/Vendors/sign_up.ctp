<?php
    $submitRedirect = $this->Url->build([
        '_name'  => $themeFunction->routePrefix() . 'VendorVerification'
    ]);

    $citiesUrl = $this->Url->build([
        '_name'  => $themeFunction->routePrefix() . 'UserActionLoadCities'
    ]);
    
    $signInUrl = $this->Url->build([
        '_name'  => $themeFunction->routePrefix() . 'VendorSignIn'
    ]);
?>
<?php
    echo $this->Form->create($vendorSignUp, [
        'id'                    => 'form-sign-up',
        'class'                 => 'form uk-form-stacked',
        'data-parsley-validate' => '',
        'url'                   => ['_name' => $themeFunction->routePrefix() . 'VendorAjaxSignUp']
    ]);

    echo $this->Form->hidden('country', ['id' => 'form-country']);
    echo $this->Form->hidden('country_code', ['id' => 'form-country-code', 'value' => 'id']);
    echo $this->Form->hidden('calling_code', ['id' => 'form-calling-code', 'value' => '62']);
?>
<h3 class="non-uikit mb-4">Sign Up</h3>
<p class="mb-5">
Become a member today to get access to your custom profile and<br>our exclusive business insights
</p>
<div class="nano">
    <div class="nano-content">
        <div class="row">
            <div class="col-md-12">
                <div class="" uk-grid>
                    <div class="uk-margin-small">
                        <h5 class="non-uikit text-title text-left">Vendor Information</h5>
                        <span class="devider-core"></span>
                    </div>
                    <div class="uk-margin-small uk-width-1-1">
                        <label class="uk-form-label" for="form-stacked-name">Vendor Name</label>
                        <div class="uk-form-controls">
                            <?php
                                echo $this->Form->text('name', [
                                    'id'                     => 'form-stacked-name',
                                    'class'                  => 'uk-input',
                                    'placeholder'            => 'Vendor Name',
                                    'data-parsley-minlength' => '2',
                                    'data-parsley-maxlength' => '50',
                                    'autofocus'              => 'autofocus',
                                    'required'               => 'required'
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="uk-margin-small uk-width-1-1">
                        <label class="uk-form-label" for="form-stacked-email">Email</label>
                        <div class="uk-form-controls">
                            <?php
                                echo $this->Form->text('email', [
                                    'type'                   => 'email',
                                    'id'                     => 'form-stacked-email',
                                    'class'                  => 'uk-input',
                                    'placeholder'            => 'Email. E.g. weddingplanner@mail.com ',
                                    'data-parsley-type'      => 'email',
                                    'required'               => 'required'
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="uk-margin-small uk-width-1-1">
                        <label class="uk-form-label" for="form-stacked-password">Password</label>
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

                    <div class="uk-margin-small uk-width-1-1">
                        <label class="uk-form-label" for="form-stacked-repeatpassword">Repeat Password</label>
                        <div class="uk-form-controls">
                            <?php
                                echo $this->Form->password('repeatpassword', [
                                    'id'                     => 'form-stacked-repeatpassword',
                                    'class'                  => 'uk-input', 
                                    'placeholder'            => 'Repeat Password',
                                    'data-parsley-minlength' => '6',
                                    'data-parsley-maxlength' => '20',
                                    'autocomplete' 			 => '',
                                    'data-parsley-equalto'   => '#form-stacked-password',
                                    'required'               => 'required'
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 uk-margin-top">
                <div uk-grid>
                    <div class="uk-margin-small">
                        <h5 class="non-uikit text-title text-left">Contact Information</h5>
                        <span class="devider-core"></span>
                    </div>
                    <div class="uk-margin-small uk-width-1-1">
                        <label class="uk-form-label" for="form-stacked-phone">Mobile Phone Number</label>
                        <div class="uk-form-controls">
                            <?php
                                echo $this->Form->text('phone', [
                                    'id'                => 'form-stacked-phone',
                                    'class'             => 'uk-input',
                                    'data-parsley-type' => 'number',
                                    'required'          => 'required'
                                ]);
                            ?>
                        </div>
                    </div>

                    <div class="uk-margin-small uk-width-1-1">
                        <label class="uk-form-label" for="form-stacked-province">Province</label>
                        <div class="uk-form-controls">
                            <?php
                                echo $this->Form->select(
                                    'province',
                                    $rajaongkirProvinces,
                                    [
                                        'empty'    => 'Select Province',
                                        'id'       => 'form-stacked-province',
                                        'class'    => 'uk-select',
                                        'required' => 'required',
                                        'data-purplestore-url'    => $citiesUrl,
                                        'data-purplestore-target' => '#form-stacked-city'
                                    ]
                                );
                            ?>
                        </div>
                    </div>

                    <div class="uk-margin-small uk-width-1-1">
                        <label class="uk-form-label" for="form-stacked-city">City</label>
                        <div class="uk-form-controls">
                            <?php
                                echo $this->Form->select(
                                    'city',
                                    [],
                                    [
                                        'empty'    => 'Select City',
                                        'id'       => 'form-stacked-city',
                                        'class'    => 'uk-select',
                                        'required' => 'required'
                                    ]
                                );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 uk-margin-top">
                <div uk-grid>
                    <div class="uk-margin-small">
                        <h5 class="non-uikit text-title text-left">Required Documents</h5>
                        <span class="devider-core"></span>
                    </div>

                    <div class="uk-margin-small uk-width-1-1">
                        <label class="uk-form-label" for="form-stacked-ktp">KTP</label>
                        <div class="uk-form-controls">
                            <div class="uk-width-1-1" uk-form-custom="target: true">
                                <?php
                                    echo $this->Form->text('ktp', [
                                        'type'     => 'file',
                                        'id'       => 'form-stacked-ktp',
                                        'required' => 'required'
                                    ]);
                                ?>
                                <?php
                                    echo $this->Form->text('', [
                                        'class'       => 'uk-input',
                                        'placeholder' => 'Select file',
                                        'disabled'    => 'disabled'
                                    ]);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="uk-margin-small uk-width-1-1">
                        <label class="uk-form-label" for="form-stacked-npwp">NPWP</label>
                        <div class="uk-form-controls">
                            <div class="uk-width-1-1" uk-form-custom="target: true">
                                <?php
                                    echo $this->Form->text('npwp', [
                                        'type'     => 'file',
                                        'id'       => 'form-stacked-npwp',
                                        'required' => 'required'
                                    ]);
                                ?>
                                <?php
                                    echo $this->Form->text('', [
                                        'class'       => 'uk-input',
                                        'placeholder' => 'Select file',
                                        'disabled'    => 'disabled'
                                    ]);
                                ?>
                            </div>
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
    <div class="col-md-8 offset-md-2 uk-margin-large-top">
        <?php
            echo $this->Form->button('Sign up', [
                'id'    => 'button-sign-up',
                'class' => 'btn btn-primary btn-block'
            ]);
        ?>
        <p class="text-center"><a class="non-uikit" href="<?= $signInUrl ?>">Already have account? Sign In</a></p>
    </div>
</div>
<?php
    echo $this->Form->end();
?>

<?= $this->Html->script('Bridestiny./plugins/intl-tel-input/js/intlTelInput.min.js'); ?>
<?= $this->Html->script('Bridestiny./plugins/intl-tel-input/js/utils.js', ['id' => 'intl-tel-utils']); ?>

<script>
    var input = document.querySelector("#form-stacked-phone");
    var utils = document.querySelector("#intl-tel-utils").getAttribute('src');
    var iti   = window.intlTelInput(input, {
        initialCountry: "id",
        separateDialCode: true,
        allowDropdown: false,
        geoIpLookup: function(callback) {
            // $.getJSON("http://api.ipstack.com/<?= $ipAddress ?>?access_key=a8bf4c14f2e763be7d58131561cc4231", function(data) {
            $.getJSON("http://api.ipstack.com/110.139.195.147?access_key=a8bf4c14f2e763be7d58131561cc4231", function(data) {
                var countryCode = data.country_code;
                console.log(data);
                callback(countryCode);
            });
        },
        utilsScript: utils + "?1562189064761"
    });

    input.addEventListener("countrychange", function() {
        var name              = iti.getSelectedCountryData().name;
        var code              = iti.getSelectedCountryData().iso2;
        var formCountry       = document.querySelector("#form-country");
        var formCountryCode   = document.querySelector("#form-country-code");
        var formCallingCode   = document.querySelector("#form-calling-code");

        formCountry.value     = name;
        formCountryCode.value = code;
        formCallingCode.value = iti.getSelectedCountryData().dialCode;
    });
</script>

<script>
    $(document).ready(function() {
        var t = "form-sign-up",
            n = "Bridestiny.signUp",
            o = "redirect",
            a = "<?= $submitRedirect ?>",
            c = "Sign up",
            r = "Processing...";
        $("#button-sign-up").one("click",function(){ajaxSubmit(t,n,o,a,c,r)})
    })
</script>