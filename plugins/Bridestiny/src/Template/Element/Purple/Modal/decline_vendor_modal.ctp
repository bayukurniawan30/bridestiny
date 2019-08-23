<?php
    $submitRedirect = $this->Url->build([
        '_name'  => $routePrefix . 'VendorViewDetail',
        'id'     => $vendor->id
    ]);
?>

<div id="modal-decline-vendor" class="uk-flex-top purple-modal" uk-modal="bg-close: false">
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <?php
            echo $this->Form->create($form, [
                'id'                    => 'form-decline-vendor', 
                'class'                 => 'pt-3', 
                'data-parsley-validate' => '',
                'url'                   => ['action' => 'ajaxDecline']
            ]);

            echo $this->Form->hidden('id');
        ?>
        <div class=" uk-modal-body">
            <p>Are you sure want to decline <span class="bind-title"></span>? Tell the vendor why you decline the vendor account?</p>
            <div class="form-group">
                <?php
                    echo $this->Form->textarea('decline_reason', [
                        'class'                  => 'form-control',
                        'placeholder'            => 'Reason (Optional)',
                        'data-parsley-maxlength' => '255',
                        'required'               => false
                    ]);
                ?>
            </div>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <?php
                echo $this->Form->button('Cancel', [
                    'id'           => 'button-close-modal',
                    'class'        => 'btn btn-outline-primary uk-modal-close',
                    'type'         => 'button',
                    'data-target'  => '.purple-modal'
                ]);
            
                echo $this->Form->button('Yes, Decline', [
                    'id'    => 'button-decline-vendor',
                    'class' => 'btn btn-gradient-danger uk-margin-left'
                ]);
            ?>
        </div>
        <?php
            echo $this->Form->end();
        ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var vendorDecline = {
            form            : 'form-decline-vendor',
            button          : 'button-decline-vendor',
            action          : 'edit',
            redirectType    : 'redirect',
            redirect        : '<?= $submitRedirect; ?>',
            btnNormal       : 'Yes, Decline',
            btnLoading      : '<i class="fa fa-circle-o-notch fa-spin"></i> Declining...'
        };

        var targetButton = $("#"+vendorDecline.button);
        targetButton.one('click',function() {
            ajaxSubmit(vendorDecline.form, vendorDecline.action, vendorDecline.redirectType, vendorDecline.redirect, vendorDecline.btnNormal, vendorDecline.btnLoading);
        })
    })
</script>