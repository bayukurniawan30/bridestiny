<div class="card">
    <div class="card-header">
        <h4 class="card-title uk-margin-remove-bottom">About</h4>
    </div>
    <div class="card-body <?php if ($about->count() == 0) echo 'uk-padding-remove' ?>">
        <?php 
            if ($about->count() > 0):
                echo $about->first()->content;
            else:
        ?> 
        <div class="uk-alert-danger <?php if ($about->count() == 0) echo 'uk-margin-remove-bottom' ?>" uk-alert>
            <p>The vendor hasn't added data.</p>
        </div>
        <?php
            endif;
        ?>
    </div>
</div>