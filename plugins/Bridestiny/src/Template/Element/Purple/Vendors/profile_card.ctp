<?php
    $province = $this->cell('Bridestiny.Vendors::getProvinceName', [$vendor->province]);
    $city     = $this->cell('Bridestiny.Vendors::getCityName', [$vendor->city]);
?>

<div class="uk-card uk-card-default">
    <?php if ($vendor->banner !== NULL): ?>
    <div class="uk-card-media-top">
        <img src="<?= $this->request->getAttribute("webroot").'uploads/images/original/'.$vendor->banner ?>" alt="<?= $vendor->name ?>" width="100%">
    </div>
    <?php endif; ?>
    <div class="uk-card-header">
        <div class="uk-grid-small uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
                <?php if ($vendor->photo === NULL): ?>
                <img class="uk-border-circle initial-photo" src="" alt="<?= $vendor->name ?>" data-name="<?= $vendor->name ?>" data-height="40" data-width="40" data-char-count="2" data-font-size="20">
                <?php else: ?>
                <img class="uk-border-circle" width="40" height="40" src="<?= $this->request->getAttribute("webroot") . 'uploads/images/original/' . $vendor->photo ?>" alt="<?= $vendor->name ?>">
                <?php endif; ?>
            </div>
            <div class="uk-width-expand">
                <h5 class="uk-card-title uk-margin-remove-bottom"><?= $vendor->name ?></h5>
                <p class="uk-text-meta uk-margin-remove-top"><time><?= $vendor->bride_auth->text_status ?></time></p>
            </div>
        </div>
    </div>
    <div class="uk-card-body">
        <ul class="uk-list uk-list-divider">
            <li><?= $vendor->bride_auth->email ?></li>
            <li><?= $vendor->mobile_phone ?></li>
            <li><?= $city ?> - <?= $province ?></li>
        </ul>
        
    </div>
    <div class="uk-card-footer">
        
        <div uk-grid>
            <div class="uk-width-1-2"><a href="mailto:<?= $vendor->bride_auth->email ?>"><span class="uk-margin-small-right" uk-icon="icon: mail"></span> Email</a></div>
            <div class="uk-width-1-2 text-right"><a href="tel:<?= $vendor->mobile_phone ?>"><span class="uk-margin-small-right" uk-icon="icon: receiver"></span> Call</a></div>
        </div>
    </div>
</div>