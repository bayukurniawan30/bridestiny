<?php
    $vendorSignInUrl = $this->Url->build([
        '_name'  => $routePrefix . 'VendorSignIn',
    ]);

    $submitRedirect = $this->Url->build([
        '_name'  => $routePrefix . 'VendorViewDetail',
        'id'     => $vendor->id
    ]);
?>

<div id="modal-confirm-vendor" class="uk-flex-top purple-modal">
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <?php
            echo $this->Form->create($form, [
                'id'                    => 'form-confirm-vendor', 
                'class'                 => 'pt-3', 
                'data-parsley-validate' => '',
                'url'                   => ['action' => 'ajaxConfirm']
            ]);

            echo $this->Form->hidden('id');
            echo $this->Form->hidden('ds', ['value' => $vendorSignInUrl]);
        ?>
        <div class=" uk-modal-body">
            <p>Are you sure want to confirm <span class="bind-title"></span>?</p>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <?php
                echo $this->Form->button('Decline', [
                    'id'    => 'button-decline-vendor',
                    'class' => 'btn btn-outline-danger uk-modal-close',
                    'type'  => 'button',
                    'data-purple-modal' => '#modal-decline-vendor',
                    'data-purple-name'  => ''
                ]);
            
                echo $this->Form->button('Yes, Confirm Now', [
                    'id'    => 'button-confirm-vendor',
                    'class' => 'btn btn-gradient-primary uk-margin-left'
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
        var vendorConfirm = {
            form            : 'form-confirm-vendor',
            button          : 'button-confirm-vendor',
            action          : 'edit',
            redirectType    : 'redirect',
            redirect        : '<?= $submitRedirect; ?>',
            btnNormal       : 'Yes, Confirm Now',
            btnLoading      : '<i class="fa fa-circle-o-notch fa-spin"></i> Confirming...'
        };

        var targetButton = $("#"+vendorConfirm.button);
        targetButton.one('click',function() {
            ajaxSubmit(vendorConfirm.form, vendorConfirm.action, vendorConfirm.redirectType, vendorConfirm.redirect, vendorConfirm.btnNormal, vendorConfirm.btnLoading);
        })
    })
</script>