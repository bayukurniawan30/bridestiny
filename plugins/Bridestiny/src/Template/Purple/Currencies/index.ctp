<?php
    $deleteCurrenciesUrl = $this->Url->build([
		'_name'  => $routePrefix . 'Currencies',
    ]);

    $newCurrenciestUrl = $this->Url->build([
		'_name'  => $routePrefix . 'CurrenciesAction',
		'action' => 'add'
    ]);

    $removedCurrenciesUrl = $this->Url->build([
		'_name'  => $routePrefix . 'CurrenciesRemoved'
    ]);
?>

<div class="row">
    <div class="col-md-12">
        <!-- Messages -->
        <div class="uk-alert-primary" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p><span uk-icon="info"></span> Default Currency is <strong>Indonesian Rupiah (IDR)</strong>. Other currencies in Purple Store base on <a href="https://www.ecb.europa.eu/stats/policy_and_exchange_rates/euro_reference_exchange_rates/html/index.en.html" target="_blank">Europan Central Bank rates</a>.</p>
        </div>
    </div>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title uk-margin-remove-bottom">Currencies</h4>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-gradient-primary btn-toolbar-card btn-sm btn-icon-text" onclick="location.href='<?= $newCurrenciestUrl ?>'">
                    <i class="mdi mdi-pencil btn-icon-prepend"></i>
                    Add Currencies
                </button>
                <button type="button" class="btn btn-gradient-danger btn-toolbar-card btn-sm btn-icon-text uk-margin-small-left" onclick="location.href='<?= $removedCurrenciesUrl ?>'">
                	<i class="mdi mdi-delete btn-icon-prepend"></i>
                  		Trash <?php if ($deletedCurrencies > 0) echo "(" . $deletedCurrencies . ")" ?>
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
                                <th>
                                    IDR Value
                                </th>
                                <th>
                                    Status
                                </th>
                                <th class="text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($currencies as $currency): 
                                    $editUrl = $this->Url->build([
                                        '_name'  => $routePrefix . 'CurrenciesEdit',
                                        'id'     => $currency->id,
                                    ]);
                            ?>
                            <tr>
                                <td>
                                    <?= $currency->code ?>
                                </td>
                                <td>
                                    <?= $currency->full_code ?>
                                </td>
                                <td>
                                    <?= $this->cell('Bridestiny.Currencies::convert', [$currency->code, 'IDR', 1, true]); ?>
                                </td>
                                <td>
                                    <?= $currency->text_status ?>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-gradient-primary btn-rounded btn-icon" uk-tooltip="Edit Currency" onclick="location.href='<?= $editUrl; ?>'">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-gradient-danger btn-rounded btn-icon button-delete-purple" uk-tooltip="Delete <?= $currency->full_code ?>" data-purple-id="<?= $currency->id ?>" data-purple-name="<?= $currency->full_code ?>" data-purple-modal="#modal-delete-currency">
    				                    <i class="mdi mdi-delete"></i>
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
                    <p>Can't find additional currencies in your store.</p>
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
<?= $this->element('Dashboard/Modal/delete_modal', [
        'action'     => 'currency',
        'form'       => $deletedCurrencies,
        'formAction' => 'ajax-delete'
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

        var currencyDelete = {
            form            : 'form-delete-currency',
            button          : 'button-delete-currency',
            action          : 'delete',
            redirectType    : 'redirect',
            redirect        : '<?= $deleteCurrenciesUrl ?>',
            btnNormal       : false,
            btnLoading      : false
        };

        var targetButton = $("#"+currencyDelete.button);
        targetButton.one('click',function() {
            ajaxSubmit(currencyDelete.form, currencyDelete.action, currencyDelete.redirectType, currencyDelete.redirect, currencyDelete.btnNormal, currencyDelete.btnLoading);
        })
        <?php
            endif;
        ?>
    })
</script>