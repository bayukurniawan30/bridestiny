<?php
    $submitRedirect = $this->Url->build([
		'_name'  => $routePrefix . 'Currencies'
    ]);

    echo $this->Form->create($currencyEdit, [
        'id'                    => 'form-edit-currency',
        'class'                 => '',
        'data-parsley-validate' => '',
        'url'                   => ['action' => 'ajax-update']
    ]);

    echo $this->Form->hidden('id', ['value' => $currency->id]);
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
                        if ($currency->status == '1') {
                            $statusDraft   = false;
                            $statusPublish = true;
                        }
                        elseif ($currency->status == '0') {
                            $statusDraft   = true;
                            $statusPublish = false;
                        }

                        echo $this->Form->radio(
                            'status', 
                            [
                                ['value' => '0', 'text' => 'Draft', 'aria-label' => 'Select Status', 'data-labelauty' => 'Status: Draft', 'label' => false, 'checked' => $statusDraft],
                                ['value' => '1', 'text' => 'Publish', 'aria-label' => 'Select Status',  'data-labelauty' => 'Status: Publish', 'label' => false, 'checked' => true, 'checked' => $statusPublish],
                            ]
                        );
                    ?>
                </div>
            </div>
            <div class="card-footer">
                <?php
                    echo $this->Form->button('Save', [
                        'id'    => 'button-edit-currency',
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

        $('#form-edit-currency').find('select[name=code] option[value="<?= $currency->code ?>"]').attr("selected","selected");

        var currencyEdit = {
            form            : 'form-edit-currency',
            button          : 'button-edit-currency',
            action          : 'edit',
            redirectType    : 'redirect',
            redirect        : '<?= $submitRedirect; ?>',
            btnNormal       : false,
            btnLoading      : false
        };

        var targetButton = $("#"+currencyEdit.button);
        targetButton.one('click',function() {
            ajaxSubmit(currencyEdit.form, currencyEdit.action, currencyEdit.redirectType, currencyEdit.redirect, currencyEdit.btnNormal, currencyEdit.btnLoading);
        })
    })
</script>