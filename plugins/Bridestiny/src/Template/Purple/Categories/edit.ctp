<?php
    $submitRedirect = $this->Url->build([
		'_name'  => $routePrefix . 'Categories'
    ]);

    echo $this->Form->create($categoryEdit, [
        'id'                    => 'form-edit-category',
        'class'                 => '',
        'data-parsley-validate' => '',
        'url'                   => ['action' => 'ajax-update']
    ]);

    echo $this->Form->hidden('id', ['value' => $category->id]);
    echo $this->Form->hidden('image', ['value' => $category->image]);
?>
<div class="row">
    <div class="col-md-8">
        <div class="card grid-margin">
            <div class="card-header">
                <h4 class="card-title uk-margin-remove-bottom">Category Detail</h4>
            </div>
            
            <div class="card-body">
                <div class="form-group">
                    <?php
                        echo $this->Form->text('name', [
                            'class'                  => 'form-control',
                            'placeholder'            => 'Name',
                            'data-parsley-minlength' => '2',
                            'data-parsley-maxlength' => '255',
                            'uk-tooltip'             => 'title: Required. 2-255 chars.; pos: bottom-left',
                            'autofocus'              => 'autofocus',
                            'required'               => 'required',
                            'value'                  => $category->name
                        ]);
                    ?>
                </div>
                <div class="form-group">
                    <?php
                        echo $this->Form->select(
                            'parent',
                            $parent,
                            [
                                'empty'    => 'Select Parent Category',
                                'class'    => 'form-control',
                            ]
                        );
                    ?>
                </div>
                <div class="form-group custom-labelauty labelauty-2-options">
                    <?php
                        if ($category->status == '1') {
                            $statusDraft   = false;
                            $statusPublish = true;
                        }
                        elseif ($category->status == '0') {
                            $statusDraft   = true;
                            $statusPublish = false;
                        }
                        
                        echo $this->Form->radio(
                            'status', 
                            [
                                ['value' => '0', 'text' => 'Draft', 'aria-label' => 'Select Status', 'data-labelauty' => 'Status: Draft', 'label' => false, 'checked' => $statusDraft],
                                ['value' => '1', 'text' => 'Publish', 'aria-label' => 'Select Status',  'data-labelauty' => 'Status: Publish', 'label' => false, 'checked' => $statusPublish],
                            ]
                        );
                    ?>
                </div>
                <div class="form-group">
                    <?php
                        echo $this->Form->text('icon', [
                            'class'                  => 'form-control',
                            'placeholder'            => 'Icon (Optional). E.g. https://img.icons8.com/ios/{{pixelSize}}/{{color}}/wedding-dress.png',
                            'data-parsley-minlength' => '2',
                            'data-parsley-maxlength' => '255',
                            'uk-tooltip'             => 'title: Optional. Icon from https://icons8.com iOS style. {{pixelSize}} is the icon size. {{color}} is the icon color in hex format.; pos: bottom',
                            'value'                  => $category->icon
                        ]);
                    ?>
                </div>
                <div class="form-group">
                    <?php
                        echo $this->Form->textarea('description',[
                            'class'       => 'form-control',
                            'placeholder' => 'Description',
                            'rows'        => 5,
                            'required'    => false,
                            'value'       => $category->description
                        ]);
                    ?>
                </div>   
            </div>
            <div class="card-footer">
                <?php
                    echo $this->Form->button('Save', [
                        'id'    => 'button-edit-category',
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

    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <?= $this->element('Dashboard/upload_or_browse_image', [
                        'selected'     => $category->image,
                        'widgetTitle'  => 'Categopry Image',
                        'inputTarget'  => 'image',
                        'browseMedias' => $browseMedias,
                        'multiple'     => false,
                        'modalParams'  => [
                            'browseContent' => 'bride_categories::0',
                            'browseAction'  => 'send-to-input',
                            'browseTarget'  => 'image'
                        ]
                ]) ?>
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

        $('#form-edit-category').find('select[name=parent] option[value="<?= $category->parent ?>"]').attr("selected","selected");

        var categoryEdit = {
            form            : 'form-edit-category',
            button          : 'button-edit-category',
            action          : 'edit',
            redirectType    : 'redirect',
            redirect        : '<?= $submitRedirect; ?>',
            btnNormal       : false,
            btnLoading      : false
        };

        var targetButton = $("#"+categoryEdit.button);
        targetButton.one('click',function() {
            ajaxSubmit(categoryEdit.form, categoryEdit.action, categoryEdit.redirectType, categoryEdit.redirect, categoryEdit.btnNormal, categoryEdit.btnLoading);
        })
    })
</script>