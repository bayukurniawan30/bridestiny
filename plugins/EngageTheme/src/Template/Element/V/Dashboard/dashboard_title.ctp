<?php
    $province = $this->cell('Bridestiny.Vendors::getProvinceName', [$userData->province]);
    $city     = $this->cell('Bridestiny.Vendors::getCityName', [$userData->city]);
?>

<section class="fullscreen-slideshowS relative mt-0 paroller" data-paroller-factor="-0.2" style="background-image: url(<?= $this->Url->image('slideshow/s1.jpg'); ?>); background-size: cover">
    <div class="fullscreen-slideshow-content dashboard-with-image">
        <div class="item"> 
            <div class="detail-page text-center">
                <img class="<?php if ($userData->photo == NULL) echo 'initial-photo'; ?> uk-border-circle uk-margin-bottom" width="80" height="80" <?php if ($userData->photo != NULL): ?>src="<?= $this->request->getAttribute("webroot") . 'uploads/images/original/' . $userData->photo ?>"<?php endif; ?> data-height="80" data-width="80" data-char-count="2" data-font-size="30" data-name="<?= $userData->full_name ?>">

                <h3 class="text-white non-uikit bridestiny-page-title text-uppercase lt-2" style="margin-bottom: 20px;"><?= $userData->name ?></h3>

                <div class="bridestiny-dashboard-page-title-divider"></div>
                <p class="text-white"><i class="fa fa-star"></i> 4.5 from 5 Review <i class="fa fa-map-marker uk-margin-left"></i> <?= $city ?> - <?= $province ?></p>
            </div>
        </div>
    </div>
</section>