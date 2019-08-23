<div class="col-md-12">
    <!-- Messages -->
    <?php
        if ($vendor->status == 1):
    ?>
    <div class="uk-alert-warning" uk-alert>
        <p><span uk-icon="warning"></span> <?= $vendor->name ?> data need to be reviewed. Please check the vendor data and documents.</p>
    </div>

    <a class="alert-confirm-vendor" href="#" data-purple-modal="#modal-confirm-vendor" data-purple-name="<?= $vendor->name ?>" data-purple-id="<?= $vendor->id ?>"><div class="uk-alert-primary" uk-alert>
        <p><span uk-icon="question"></span> Confirm this vendor account? Confirming this vendor will make the vendor account active and can sign in to Bridestiny.</p>
    </div></a>
    <?php
        elseif ($vendor->status == 3):
    ?>
    <div class="uk-alert-primary" uk-alert>
        <p><span uk-icon="info"></span> <?= $vendor->name ?> has been confirmed and active.</p>
    </div>
    <?php
        elseif ($vendor->status == 4):
    ?>
    <div class="uk-alert-primary" uk-alert>
        <p><span uk-icon="info"></span> <?= $vendor->name ?> has been decline. <?= $vendor->decline_reason ?></p>
    </div>
    <?php
        endif;
    ?>
</div>