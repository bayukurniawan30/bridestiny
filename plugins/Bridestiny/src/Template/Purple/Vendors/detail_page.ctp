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
            if ($vendor->bride_auth->status == '1' || $vendor->bride_auth->status == '2' || $vendor->bride_auth->status == '3') {
                echo $this->element('Bridestiny.Purple/Vendors/profile_navigation', [
                    'vendor' => $vendor,
                ]);
            }
        ?>
    </div>

    <div class="col-md-8 grid-margin">
        <?php
            if ($this->request->getParam('page') == 'documents') {
                echo $this->element('Bridestiny.Purple/Vendors/detail_documents');
            }
            elseif ($this->request->getParam('page') == 'about') {
                echo $this->element('Bridestiny.Purple/Vendors/detail_about');
            }
        ?>
    </div>
</div>

<?php
    if ($vendor->bride_auth->status == '3') {
        echo $this->element('Bridestiny.Purple/Modal/confirm_vendor_modal', [
            'form' => $vendorConfirm,
            'vendor' => $vendor,
        ]);

        echo $this->element('Bridestiny.Purple/Modal/decline_vendor_modal', [
            'form' => $vendorReject,
            'vendor' => $vendor,
        ]);
    }
?>
        