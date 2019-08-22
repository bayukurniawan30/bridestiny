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
                <h3 class="uk-card-title uk-margin-remove-bottom"><?= $vendor->name ?></h3>
                <p class="uk-text-meta uk-margin-remove-top"><time><?= $vendor->text_status ?></time></p>
            </div>
        </div>
    </div>
    <div class="uk-card-body">
        <h5 class="uk-card-title product-card-title"><a href="#"><?= $vendor->name ?></a></h5>
        
    </div>
    <div class="uk-card-footer">
        <a href="#">Edit Product</a>
    </div>
</div>