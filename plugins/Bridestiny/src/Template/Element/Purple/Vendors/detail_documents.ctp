<div class="card">
    <div class="card-header">
        <h4 class="card-title uk-margin-remove-bottom">Documents</h4>
    </div>
    <div class="card-body uk-padding-remove">
        <?php
            $ktpImage  = $this->request->getAttribute("webroot") . 'uploads/images/original/' . $ktp->name;
            $npwpImage = $this->request->getAttribute("webroot") . 'uploads/images/original/' . $npwp->name;

        ?>
        <ul id="" class="" uk-grid>
            <li class="uk-width-1-1 uk-margin-remove-top" style="position: relative">
                <div class="uk-card uk-card-default uk-card-small uk-card-body">
                    KTP <?= $vendor->ktp_number ?>

                    <div class="uk-inline uk-align-right" uk-lightbox>
                        <a href="<?= $ktpImage ?>" class="uk-margin-small-right" data-caption="KTP <?= $vendor->ktp_number ?> - <?= $vendor->name ?>" uk-icon="icon: image" uk-tooltip="Click to view KTP"></a>
                    </div>
                </div>
            </li>
            <li class="uk-width-1-1 uk-margin-remove-top" style="position: relative">
                <div class="uk-card uk-card-default uk-card-small uk-card-body">
                    NPWP <?= $vendor->npwp_number ?>

                    <div class="uk-inline uk-align-right" uk-lightbox>
                        <a href="<?= $npwpImage ?>" class="uk-margin-small-right" data-caption="KTP <?= $vendor->ktp_number ?> - <?= $vendor->name ?>" uk-icon="icon: image" uk-tooltip="Click to view NPWP"></a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>