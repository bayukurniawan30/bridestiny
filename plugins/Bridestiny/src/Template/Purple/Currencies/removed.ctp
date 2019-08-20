<?php
    $allCurrencyUrl = $this->Url->build([
		'_name'  => $routePrefix . 'Currencies',
    ]);
?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title uk-margin-remove-bottom">Currencies</h4>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-gradient-primary btn-toolbar-card btn-sm btn-icon-text" onclick="location.href='<?= $allCurrencyUrl ?>'">
                    <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
                    All Currencies
                </button>
            </div>
            <div class="card-body <?php if ($currencies->count() == 0) echo 'uk-padding-remove' ?>">
                <?php
                    if ($currencies->count() > 0):
                ?>
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-justify uk-table-divider uk-table-middle purple-datatable purple-smaller-table">
                        <thead>
                            <tr>
                                <th>
                                    Code
                                </th>
                                <th>
                                    Currency
                                </th>
                                <th class="text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($currencies as $currency): 
                            ?>
                            <tr>
                                <td>
                                    <?= $currency->code ?>
                                </td>
                                <td>
                                    <?= $currency->full_code ?>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-gradient-primary btn-rounded btn-icon button-delete-purple" uk-tooltip="Restore <?= $currency->full_code ?>" data-purple-id="<?= $currency->id ?>" data-purple-name="<?= $currency->full_code ?>" data-purple-modal="#modal-restore-currency">
    				                    <i class="mdi mdi-restore"></i>
    				                </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php
                    else:
                ?>
                <div class="uk-alert-danger <?php if ($currencies->count() == 0) echo 'uk-margin-remove-bottom' ?>" uk-alert>
                    <p>Can't find deleted currencies in your store.</p>
                </div>
                <?php
                    endif;
                ?>
            </div>
        </div>
    </div>
</div>

<?php
    if ($currencies->count() > 0):
?>
<?= $this->element('PurpleStore.Purple/Modal/restore_modal', [
        'action'     => 'currency',
        'form'       => $currencyRestore,
        'formAction' => 'ajax-restore'
]) ?>
<?php
    endif;
?>

<script type="text/javascript">
    $(document).ready(function() {
    	<?php
            if ($currencies->count() > 0):
        ?>
        var dataTable = $('.purple-datatable').DataTable({
            "order": [],
            responsive: true,
            "columnDefs": [{
                "targets": -1,
                "orderable": false
            }]
        });

        var restoreDelete = {
            form            : 'form-restore-currency',
            button          : 'button-restore-currency',
            action          : 'restore',
            redirectType    : 'redirect',
            redirect        : '<?= $allCurrencyUrl ?>',
            btnNormal       : 'Yes, Restore it',
            btnLoading      : '<i class="fa fa-circle-o-notch fa-spin"></i> Restoring...'
        };

        var targetButton = $("#"+restoreDelete.button);
        targetButton.one('click',function() {
            ajaxSubmit(restoreDelete.form, restoreDelete.action, restoreDelete.redirectType, restoreDelete.redirect, restoreDelete.btnNormal, restoreDelete.btnLoading);
        })
        <?php
            endif;
        ?>
    })
</script>