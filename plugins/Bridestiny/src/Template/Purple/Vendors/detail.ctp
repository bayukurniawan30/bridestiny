<?php
    $province = $this->cell('Bridestiny.Vendors::getProvinceName', [$vendor->province]);
    $city     = $this->cell('Bridestiny.Vendors::getCityName', [$vendor->city]);

    $vendorUrl = $this->Url->build([
        '_name'  => $routePrefix . 'VendorDetail',
        'slug'   => $vendor->user_id
    ], true);
?>

<div class="row">
    <div class="col-md-12">
        <!-- Messages -->
        <?php
            if ($vendor->status == 1):
        ?>
        <div class="uk-alert-warning" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p><span uk-icon="warning"></span> <?= $vendor->name ?> data need to be reviewed. Please check the vendor data and documents.</p>
        </div>
        <?php
            endif;
        ?>
    </div>

    <div class="col-md-4 grid-margin">
        <?= $this->element('Bridestiny.Purple/Vendors/profile_card', [
            'vendor' => $vendor,
        ]) ?>

        <?php
            if ($vendor->status == '1' || $vendor->status == '2' || $vendor->status == '3') {
                echo $this->element('Bridestiny.Purple/Vendors/profile_navigation', [
                    'vendor' => $vendor,
                ]);
            }
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
                    <dd><?= $vendor->email ?></dd>

                    <dt class="uk-margin-small-bottom"><strong>Phone</strong></dt>
                    <dd><?= $vendor->mobile_phone ?></dd>

                    <dt class="uk-margin-small-bottom"><strong>Registered Date</strong></dt>
                    <dd><?= date($settingsDateFormat.' '.$settingsTimeFormat, strtotime($vendor->created)) ?></dd>

                    <dt class="uk-margin-small-bottom"><strong>Location</strong></dt>
                    <dd><?= $city ?> - <?= $province ?></dd>

                    <dt class="uk-margin-small-bottom"><strong>Vendor URL</strong></dt>
                    <dd><a href="<?= $vendorUrl ?>" target="_blank"><?= $vendorUrl ?></a></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
        