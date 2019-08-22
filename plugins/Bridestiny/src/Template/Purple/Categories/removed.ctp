<?php
    $allCategoryUrl = $this->Url->build([
		'_name'  => $routePrefix . 'Categories',
    ]);
?>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title uk-margin-remove-bottom">Categories</h4>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-gradient-primary btn-toolbar-card btn-sm btn-icon-text" onclick="location.href='<?= $allCategoryUrl ?>'">
                    <i class="mdi mdi-arrow-left btn-icon-prepend"></i>
                    All Category
                </button>
            </div>
            <div class="card-body <?php if ($categories->count() == 0) echo 'uk-padding-remove' ?>">
                <?php
                    if ($categories->count() > 0):
                ?>
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-justify uk-table-divider uk-table-middle purple-datatable purple-smaller-table">
                        <thead>
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Parent
                                </th>
                                <th>
                                    Icon
                                </th>
                                <th>
                                    Total Packages
                                </th>
                                <th>
                                    Description
                                </th>
                                <th class="text-center">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($categories as $category): 
                                    $editUrl = $this->Url->build([
                                        '_name'  => $routePrefix . 'CategoriesEdit',
                                        'id'     => $category->id,
                                    ]);

                                    $totalPackages = $this->cell('Bridestiny.Categories::totalPackagesInCategory', [$category->id]);
                            ?>
                            <tr>
                                <td>
                                    <?= $category->name ?>
                                </td>
                                <td>
                                    <?php
                                        if ($category->parent == NULL) {
                                            echo '-';
                                        }
                                        else {
                                            echo $this->cell('Bridestiny.Categories::parentCategory', [$category->parent]);
                                        }
                                    ?>
                                </td>
                                <td>
                                    <img src="<?= $category->default_icon ?>">
                                </td>
                                <td>
                                    <?= $totalPackages ?>
                                </td>
                                <td>
                                    <?= $this->Text->truncate(
                                            $category->description,
                                            25,
                                            [
                                                'ellipsis' => '<span class="uk-text-primary" uk-tooltip="'.$category->description.'">...</span>',
                                                'exact' => false
                                            ]
                                    ); ?>
                                </td> 
                                <td class="text-center">
                                    <button type="button" class="btn btn-gradient-primary btn-rounded btn-icon button-delete-purple" uk-tooltip="Restore <?= $category->name ?>" data-purple-id="<?= $category->id ?>" data-purple-name="<?= $category->name ?>" data-purple-modal="#modal-restore-category">
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
                <div class="uk-alert-danger <?php if ($categories->count() == 0) echo 'uk-margin-remove-bottom' ?>" uk-alert>
                    <p>Can't find deleted category.</p>
                </div>
                <?php
                    endif;
                ?>
            </div>
        </div>
    </div>
</div>

<?php
    if ($categories->count() > 0):
?>
<?= $this->element('Bridestiny.Purple/Modal/restore_modal', [
        'action'     => 'category',
        'form'       => $categoryRestore,
        'formAction' => 'ajax-restore'
]) ?>
<?php
    endif;
?>

<script type="text/javascript">
    $(document).ready(function() {
    	<?php
            if ($categories->count() > 0):
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
            form            : 'form-restore-category',
            button          : 'button-restore-category',
            action          : 'restore',
            redirectType    : 'redirect',
            redirect        : '<?= $allCategoryUrl ?>',
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