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
        'page'   => 'projects'
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
    <div class="uk-card-body uk-padding-remove">
        <ul id="" class="" uk-grid>
            <li class="uk-width-1-1 uk-margin-remove-top" style="position: relative">
                <a href="<?= $documentsUrl ?>">
                <div class="uk-card uk-card-default uk-card-small uk-card-body nav-page <?php if ($this->request->getParam('page') == 'documents') echo 'nav-selected-page' ?>">
                    Documents

                    <div class="uk-inline uk-align-right">
                        <span class="uk-margin-small-right" uk-icon="icon: file-edit"></span>
                    </div>
                </div>
                </a>
            </li>

            <?php
                if ($vendor->bride_auth->status == '1'):
            ?>
            <li class="uk-width-1-1 uk-margin-remove-top" style="position: relative">
                <a href="<?= $aboutUrl ?>">
                <div class="uk-card uk-card-default uk-card-small uk-card-body nav-page <?php if ($this->request->getParam('page') == 'about') echo 'nav-selected-page' ?>"">
                    About

                    <div class="uk-inline uk-align-right">
                        <span class="uk-margin-small-right" uk-icon="icon: user"></span>
                    </div>
                </div>
                </a>
            </li> 

            <li class="uk-width-1-1 uk-margin-remove-top" style="position: relative">
                <a href="<?= $portfoliosUrl ?>">
                <div class="uk-card uk-card-default uk-card-small uk-card-body nav-page <?php if ($this->request->getParam('page') == 'projects') echo 'nav-selected-page' ?>"">
                Projects

                    <div class="uk-inline uk-align-right">
                        <span class="uk-margin-small-right" uk-icon="icon: thumbnails"></span>
                    </div>
                </div>
                </a>
            </li>

            <li class="uk-width-1-1 uk-margin-remove-top" style="position: relative">
                <a href="<?= $faqsUrl ?>">
                <div class="uk-card uk-card-default uk-card-small uk-card-body nav-page <?php if ($this->request->getParam('page') == 'faqs') echo 'nav-selected-page' ?>"">
                FAQs

                    <div class="uk-inline uk-align-right">
                        <span class="uk-margin-small-right" uk-icon="icon: question"></span>
                    </div>
                </div>
                </a>
            </li>

            <li class="uk-width-1-1 uk-margin-remove-top" style="position: relative">
                <a href="<?= $productsUrl ?>">
                <div class="uk-card uk-card-default uk-card-small uk-card-body nav-page <?php if ($this->request->getParam('page') == 'products') echo 'nav-selected-page' ?>"">
                Products

                    <div class="uk-inline uk-align-right">
                        <span class="uk-margin-small-right" uk-icon="icon: list"></span>
                    </div>
                </div>
                </a>
            </li>
            <?php
                endif;
            ?> 
        </ul>
    </div>
</div>