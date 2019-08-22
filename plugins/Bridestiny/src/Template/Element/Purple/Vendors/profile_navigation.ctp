<?php
    $documentsUrl = $this->Url->build([
        '_name'  => $routePrefix . 'VendorViewDetailPage',
        'id'     => $vendor->id,
        'page'   => 'documents'
    ]);

    $aboutUrl = $this->Url->build([
        '_name'  => $routePrefix . 'VendorViewDetailPage',
        'id'     => $vendor->id,
        'page'   => 'about'
    ]);

    $portfoliosUrl = $this->Url->build([
        '_name'  => $routePrefix . 'VendorViewDetailPage',
        'id'     => $vendor->id,
        'page'   => 'portfolios'
    ]);

    $faqsUrl = $this->Url->build([
        '_name'  => $routePrefix . 'VendorViewDetailPage',
        'id'     => $vendor->id,
        'page'   => 'faqs'
    ]);

    $productsUrl = $this->Url->build([
        '_name'  => $routePrefix . 'VendorViewDetailPage',
        'id'     => $vendor->id,
        'page'   => 'products'
    ]);
?>
<div class="uk-card uk-card-default uk-margin-top">
    <div class="uk-card-body">
        <ul class="uk-nav uk-nav-default">
            <li><a href="<?= $documentsUrl ?>"><span class="uk-margin-small-right" uk-icon="icon: file-edit"></span> Documents</a></li>
            <?php
                if ($vendor->status == '2' || $vendor->status == '3'):
            ?>
            <li><a href="<?= $aboutUrl ?>"><span class="uk-margin-small-right" uk-icon="icon: user"></span> About</a></li>
            <li><a href="<?= $portfoliosUrl ?>"><span class="uk-margin-small-right" uk-icon="icon: thumbnails"></span> Portfolios</a></li>
            <li><a href="<?= $faqsUrl ?>"><span class="uk-margin-small-right" uk-icon="icon: question"></span> FAQs</a></li>
            <li><a href="<?= $productsUrl ?>"><span class="uk-margin-small-right" uk-icon="icon: list"></span> Products</a></li>
            <?php
                endif;
            ?>
        </il>
    </div>
</div>