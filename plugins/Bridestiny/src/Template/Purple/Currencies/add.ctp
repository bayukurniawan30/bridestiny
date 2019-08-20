<?php
    $submitRedirect = $this->Url->build([
		'_name'  => $routePrefix . 'Currencies'
    ]);

    echo $this->Form->create($currencyAdd, [
        'id'                    => 'form-add-currency',
        'class'                 => '',
        'data-parsley-validate' => '',
        'url'                   => ['action' => 'ajax-add']
    ]);
?>

<div class="row">
    <div class="col-md-6">
        <div class="card grid-margin">
            <div class="card-header">
                <h4 class="card-title uk-margin-remove-bottom">Currency Detail</h4>
            </div>
            
            <div class="card-body">
                <div class="form-group">
                    <?php
                        echo $this->Form->select(
                            'code',
                            $options,
                            [
                                'empty' => 'Select Currency Code',
                                'class' => 'form-control'
                            ]
                        );
                    ?>
                </div>
                <div class="form-group custom-labelauty labelauty-2-options">
                    <?php
                        echo $this->Form->radio(
                            'status', 
                            [
                                ['value' => '0', 'text' => 'Draft', 'aria-label' => 'Select Status', 'data-labelauty' => 'Status: Draft', 'label' => false],
                                ['value' => '1', 'text' => 'Publish', 'aria-label' => 'Select Status',  'data-labelauty' => 'Status: Publish', 'label' => false, 'checked' => true],
                            ]
                        );
                    ?>
                </div>
            </div>
            <div class="card-footer">
                <?php
                    echo $this->Form->button('Save', [
                        'id'    => 'button-add-currency',
                        'class' => 'btn btn-gradient-primary'
                    ]);

                    echo $this->Form->button('Cancel', [
                        'class'   => 'btn btn-outline-primary uk-margin-left',
                        'type'    => 'button',
                        'onclick' => 'location.href = \''.$submitRedirect.'\''
                    ]);
                ?>
            </div>
        </div>
    </div>
</div>
<?php
    echo $this->Form->end();
?>

<script type="text/javascript">
    $(document).ready(function() {
        $(":radio").labelauty();

        var currencyAdd = {
            form            : 'form-add-currency',
            button          : 'button-add-currency',
            action          : 'add',
            redirectType    : 'redirect',
            redirect        : '<?= $submitRedirect; ?>',
            btnNormal       : false,
            btnLoading      : false
        };

        var targetButton = $("#"+currencyAdd.button);
        targetButton.one('click',function() {
            ajaxSubmit(currencyAdd.form, currencyAdd.action, currencyAdd.redirectType, currencyAdd.redirect, currencyAdd.btnNormal, currencyAdd.btnLoading);
        })
    })
</script>