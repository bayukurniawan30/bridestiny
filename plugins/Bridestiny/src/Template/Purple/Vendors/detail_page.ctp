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
                <h4 class="card-title uk-margin-remove-bottom">Documents</h4>
            </div>
            <div class="card-body">
                <?php
                    $ktpImage = $this->request->getAttribute("webroot") . 'uploads/images/original/' . $ktp->name;
                    $npwpImage = $this->request->getAttribute("webroot") . 'uploads/images/original/' . $npwp->name;

                ?>
                <div uk-grid>
                    <div>
                        <div uk-lightbox>
                            <a class="uk-button uk-button-default" href="<?= $ktpImage ?>" data-alt="KTP" data-caption="KTP - <?= $vendor->name ?>">Open KTP</a>
                        </div>    
                    </div>
                    <div>
                        <div uk-lightbox>
                            <a class="uk-button uk-button-default" href="<?= $npwpImage ?>" data-alt="NPWP" data-caption="NPWP - <?= $vendor->name ?>">Open NPWP</a>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        