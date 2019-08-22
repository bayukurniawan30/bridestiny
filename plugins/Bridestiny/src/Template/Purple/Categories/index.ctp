<?php
    $deleteCategoryUrl = $this->Url->build([
		'_name'  => $routePrefix . 'Categories',
    ]);

    $newCategorytUrl = $this->Url->build([
		'_name'  => $routePrefix . 'CategoriesAction',
		'action' => 'add'
    ]);

    $removedCategoriesUrl = $this->Url->build([
		'_name'  => $routePrefix . 'CategoriesRemoved'
    ]);
?>

<div class="row">
    <div class="col-md-12">
        <!-- Messages -->
        <?php
            if ($unpublishCategories > 0):
        ?>
        <div class="uk-alert-warning" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p><span uk-icon="warning"></span> You have <strong><?= $unpublishCategories ?> unpublish</strong> category(s). All vendor's packages in an unpublished category will not be displayed.</p>
        </div>
        <?php
            endif;
        ?>
    </div>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title uk-margin-remove-bottom">Categories</h4>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-gradient-primary btn-toolbar-card btn-sm btn-icon-text" onclick="location.href='<?= $newCategorytUrl ?>'">
                    <i class="mdi mdi-pencil btn-icon-prepend"></i>
                    Add Category
                </button>
                <button type="button" class="btn btn-gradient-danger btn-toolbar-card btn-sm btn-icon-text uk-margin-small-left" onclick="location.href='<?= $removedCategoriesUrl ?>'">
                	<i class="mdi mdi-delete btn-icon-prepend"></i>
                  		Trash <?php if ($deletedCategory > 0) echo "(" . $deletedCategory . ")" ?>
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
                                <th>
                                    Last Mod
                                </th>
                                <th>
                                    Status
                                </th>
                                <th class="text-center" width="120">
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
                                <td>
                                    <?= date($settingsDateFormat.' '.$settingsTimeFormat, strtotime($category->last_modified)) ?>
                                </td>
                                <td>
                                    <?= $category->text_status ?>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-gradient-primary btn-rounded btn-icon" uk-tooltip="Edit Category" onclick="location.href='<?= $editUrl; ?>'">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-gradient-danger btn-rounded btn-icon button-delete-purple" uk-tooltip="Delete <?= $category->name ?>" data-purple-id="<?= $category->id ?>" data-purple-name="<?= $category->name ?>" data-purple-modal="#modal-delete-category">
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
                <div class="uk-alert-danger <?php if ($categories->count() == 0) echo 'uk-margin-remove-bottom' ?>" uk-alert>
                    <p>Can't find category.</p>
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
<?= $this->element('Dashboard/Modal/delete_modal', [
        'action'     => 'category',
        'form'       => $categoryDelete,
        'formAction' => 'ajax-delete'
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

        var categoryDelete = {
            form            : 'form-delete-category',
            button          : 'button-delete-category',
            action          : 'delete',
            redirectType    : 'redirect',
            redirect        : '<?= $deleteCategoryUrl ?>',
            btnNormal       : false,
            btnLoading      : false
        };

        var targetButton = $("#"+categoryDelete.button);
        targetButton.one('click',function() {
            ajaxSubmit(categoryDelete.form, categoryDelete.action, categoryDelete.redirectType, categoryDelete.redirect, categoryDelete.btnNormal, categoryDelete.btnLoading);
        })
        <?php
            endif;
        ?>
    })
</script>