<?php
    $submitRedirect = $this->Url->build([
        '_name'  => $themeFunction->routePrefix() . 'VendorDashboardAction',
        'action' => 'profile'
    ]);

    $citiesUrl = $this->Url->build([
        '_name'  => $themeFunction->routePrefix() . 'UserActionLoadCities'
    ]);

    $vendorUrl = $this->Url->build([
        '_name'  => $themeFunction->routePrefix() . 'VendorDetail',
        'slug'   => ''
    ], true);
?>

<?= $this->element('V/Dashboard/dashboard_title') ?>

<?= $this->element('breadcrumb', [
    'breadcrumb' => $breadcrumb
]) ?>

<?= $this->element('V/Dashboard/dashboard_navigation') ?>

<section class="register-form bg-white mt-0" style="padding-top: 30px;">
    <div class="container">
        <?php
            echo $this->Form->create($vendorProfileForm, [
                'id'                    => 'form-edit-profile',
                'class'                 => 'form uk-form-stacked dashboard-form',
                'data-parsley-validate' => '',
                'url'                   => ['_name' => $themeFunction->routePrefix() . 'VendorDashboardAction', 'action' => 'ajaxUpdateProfile']
            ]);

            echo $this->Form->hidden('id', ['value' => $userData->id]);
            echo $this->Form->hidden('country', ['id' => 'form-country', 'value' => 'Indonesia']);
            echo $this->Form->hidden('country_code', ['id' => 'form-country-code', 'value' => $userData->country_code]);
            echo $this->Form->hidden('calling_code', ['id' => 'form-calling-code', 'value' => $userData->calling_code]);
        ?>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="pt-4">Profile Vendor</h3>
                        <hr>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="uk-form-label" for="form-stacked-userid">Vendor ID<span class="required-form-label">*</span></label>
                        <div class="uk-form-controls">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><?= $vendorUrl ?></span>
                                </div>
                                <?php
                                    echo $this->Form->text('user_id', [
                                        'id'                     => 'form-stacked-userid',
                                        'class'                  => 'form-control',
                                        'placeholder'            => 'Vendor ID',
                                        'data-parsley-minlength' => '2',
                                        'data-parsley-maxlength' => '50',
                                        'data-parsley-errors-container' => '#error-form-stacked-userid',
                                        'required'               => 'required',
                                        'value'                  => $userData->user_id
                                    ]);
                                ?>
                            </div>
                        </div>
                        <div id="error-form-stacked-userid"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="uk-form-label" for="form-stacked-name">Vendor Name<span class="required-form-label">*</span></label>
                        <div class="uk-form-controls">
                            <?php
                                echo $this->Form->text('name', [
                                    'id'                     => 'form-stacked-name',
                                    'class'                  => 'uk-input',
                                    'placeholder'            => 'Vendor Name',
                                    'data-parsley-minlength' => '2',
                                    'data-parsley-maxlength' => '50',
                                    'autofocus'              => 'autofocus',
                                    'required'               => 'required',
                                    'value'                  => $userData->name
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="uk-form-label" for="form-stacked-email">Email<span class="required-form-label">*</span></label>
                        <div class="uk-form-controls">
                            <?php
                                echo $this->Form->text('email', [
                                    'type'                   => 'email',
                                    'id'                     => 'form-stacked-email',
                                    'class'                  => 'uk-input',
                                    'placeholder'            => 'Email. E.g. weddingplanner@mail.com ',
                                    'data-parsley-type'      => 'email',
                                    'required'               => 'required',
                                    'value'                  => $userData->bride_auth->email
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="uk-form-label" for="form-stacked-phone">Mobile Phone Number<span class="required-form-label">*</span></label>
                        <div class="uk-form-controls">
                            <?php
                                echo $this->Form->text('phone', [
                                    'id'       => 'form-stacked-phone',
                                    'class'    => 'uk-input',
                                    'required' => 'required',
                                    'value'    => $userData->phone
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="uk-form-label" for="form-stacked-name">Address<span class="required-form-label">*</span></label>
                        <div class="uk-form-controls">
                            <?php
                                echo $this->Form->text('address', [
                                    'id'                     => 'form-stacked-name',
                                    'class'                  => 'uk-input',
                                    'placeholder'            => 'Address',
                                    'data-parsley-minlength' => '10',
                                    'data-parsley-maxlength' => '100',
                                    'required'               => 'required',
                                    'value'                  => $userData->address
                                ]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="uk-form-label" for="form-stacked-province">Province<span class="required-form-label">*</span></label>
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
                    <div class="form-group col-md-6">
                        <label class="uk-form-label" for="form-stacked-city">City<span class="required-form-label">*</span></label>
                        <div class="uk-form-controls">
                            <?php
                                echo $this->Form->select(
                                    'city',
                                    $rajaongkirCities,
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
                    <div class="form-group col-md-12">
                        <label class="uk-form-label" for="form-stacked-about">Tell couples about your company<span class="required-form-label">*</span></label>
                        <div class="uk-form-controls">
                            <?php
                                echo $this->Form->textarea('bride_vendor_about.content', [
                                    'id'                     => 'form-stacked-about',
                                    'class'                  => 'uk-textarea',
                                    'placeholder'            => 'Max 1000 characters.',
                                    'data-parsley-maxlength' => '1000',
                                    'required'               => 'required',
                                    'value'                  => $vendorAbout
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                $ktpImage  = $this->request->getAttribute("webroot") . 'uploads/images/original/' . $userData->ktp;
                $npwpImage = $this->request->getAttribute("webroot") . 'uploads/images/original/' . $userData->npwp;

            ?>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="pt-4">Documents</h3>
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <ul class="uk-list uk-list-divider">
                            <li>
                                <h5>KTP</h5>
                                <div class="uk-inline uk-align-left uk-margin-remove-bottom">
                                    <?= $userData->ktp_number ?>
                                </div>
                                <div class="uk-inline uk-align-right" uk-lightbox>
                                    <a href="<?= $ktpImage ?>" class="non-uikit dashboard-uk-icon" uk-icon="icon: image" data-caption="KTP <?= $userData->ktp_number ?> - <?= $userData->name ?>"></a>
                                </div>
                            </li>
                            <li>
                                <h5>NPWP</h5>
                                <div class="uk-inline uk-align-left uk-margin-remove-bottom">
                                    <?= $userData->npwp_number ?>
                                </div>
                                <div class="uk-inline uk-align-right" uk-lightbox>
                                    <a href="<?= $npwpImage ?>" class="non-uikit dashboard-uk-icon" uk-icon="icon: image" data-caption="NPWP <?= $userData->npwp_number ?> - <?= $userData->name ?>"></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="row">
            <div class="col-md-8 uk-margin-top">
                <div id="error-result"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mt-4 text-center">
                <?php
                    echo $this->Form->button('Save', [
                        'id'    => 'button-edit-profile',
                        'class' => 'btn btn-brideme-border fade-hover-color w-25',
                    ]);
                ?>
            </div>
        </div>
            
        </div>
        <div class="clear"></div>
        <br>
        <?php
            echo $this->Form->end();
        ?>
    </div>
</section>

<?= $this->Html->script('Bridestiny./plugins/intl-tel-input/js/intlTelInput.min.js'); ?>
<?= $this->Html->script('Bridestiny./plugins/intl-tel-input/js/utils.js', ['id' => 'intl-tel-utils']); ?>
<?= $this->Html->script('/plugins/inputmask/jquery.inputmask.min.js'); ?>

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
        $('#form-edit-profile').find('select[name=province] option[value="<?= $userData->province ?>"]').attr("selected","selected");
        $('#form-edit-profile').find('select[name=city] option[value="<?= $userData->city ?>"]').attr("selected","selected");

        $('#form-stacked-phone').inputmask("999999999999");

        var t = "form-edit-profile",
            n = "Bridestiny.vendorProfile",
            o = "redirect",
            a = "<?= $submitRedirect ?>",
            c = "Save",
            r = "Processing...";
        $("#button-edit-profile").one("click",function(){ajaxSubmit(t,n,o,a,c,r)})
    })
</script>