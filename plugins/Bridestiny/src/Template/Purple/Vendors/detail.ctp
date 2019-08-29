<?php
    $province = $this->cell('Bridestiny.Vendors::getProvinceName', [$vendor->province]);
    $city     = $this->cell('Bridestiny.Vendors::getCityName', [$vendor->city]);

    $vendorUrl = $this->Url->build([
        '_name'  => $routePrefix . 'VendorDetail',
        'slug'   => $vendor->user_id
    ], true);
?>

<div class="row">
    <?= $this->element('Bridestiny.Purple/Vendors/messages', [
        'vendor' => $vendor,
    ]) ?>

    <div class="col-md-4 grid-margin">
        <?= $this->element('Bridestiny.Purple/Vendors/profile_card', [
            'vendor' => $vendor,
        ]) ?>

        <?php
            echo $this->element('Bridestiny.Purple/Vendors/profile_navigation', [
                'vendor' => $vendor,
            ]);
        ?>
    </div>

    <div class="col-md-8 grid-margin">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title uk-margin-remove-bottom">Profile</h4>
            </div>
            <div class="card-body">
                <dl class="uk-description-list uk-description-list-divider">
                    <dt class="uk-margin-small-bottom"><strong>Vendor Name</strong></dt>
                    <dd><?= $vendor->name ?></dd>

                    <dt class="uk-margin-small-bottom"><strong>Email</strong></dt>
                    <dd><?= $vendor->bride_auth->email ?></dd>

                    <dt class="uk-margin-small-bottom"><strong>Phone</strong></dt>
                    <dd><?= $vendor->mobile_phone ?></dd>

                    <dt class="uk-margin-small-bottom"><strong>Registered Date</strong></dt>
                    <dd><?= date($settingsDateFormat.' '.$settingsTimeFormat, strtotime($vendor->created)) ?></dd>

                    <?php
                        if ($vendor->status == '3'):
                    ?>
                    <dt class="uk-margin-small-bottom"><strong>Active Date</strong></dt>
                    <dd><?= date($settingsDateFormat.' '.$settingsTimeFormat, strtotime($vendor->confirm_date)) ?></dd>
                    <?php
                        elseif ($vendor->status == '4'):
                    ?>
                    <dt class="uk-margin-small-bottom"><strong>Decline Date</strong></dt>
                    <dd><?= date($settingsDateFormat.' '.$settingsTimeFormat, strtotime($vendor->decline_date)) ?></dd>
                    <?php
                        endif;
                    ?>
                    <dt class="uk-margin-small-bottom"><strong>Address and Location</strong></dt>
                    <dd><?= $vendor->address ?>, <?= $city ?> - <?= $province ?></dd>

                    <dt class="uk-margin-small-bottom"><strong>Vendor URL</strong></dt>
                    <dd><a href="<?= $vendorUrl ?>" target="_blank"><?= $vendorUrl ?></a></dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<?php
    if ($vendor->bride_auth->status == '3') {
        echo $this->element('Bridestiny.Purple/Modal/confirm_vendor_modal', [
            'form'   => $vendorConfirm,
            'vendor' => $vendor,
        ]);

        echo $this->element('Bridestiny.Purple/Modal/decline_vendor_modal', [
            'form'   => $vendorReject,
            'vendor' => $vendor,
        ]);
    }
?>
        