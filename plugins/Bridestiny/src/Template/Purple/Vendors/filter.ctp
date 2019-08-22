<?php
    $filterUnverifiedUrl = $this->Url->build([
        '_name'  => $routePrefix . 'VendorsFilter',
        'filter' => 'unverified',
    ]);

    $filterVerifiedUrl = $this->Url->build([
        '_name'  => $routePrefix . 'VendorsFilter',
        'filter' => 'verified',
    ]);

    $filterBannedUrl = $this->Url->build([
        '_name'  => $routePrefix . 'VendorsFilter',
        'filter' => 'banned',
    ]);

    $filterActiveUrl = $this->Url->build([
        '_name'  => $routePrefix . 'VendorsFilter',
        'filter' => 'active',
    ]);
?>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title uk-margin-remove-bottom"><?= ucwords($this->request->getParam('filter')) ?> Vendors</h4>
            </div>
            <div class="card-toolbar">
                <div class="uk-inline uk-align-right" style="margin-bottom: 0">
                    <button type="button" class="btn btn-gradient-success btn-toolbar-card btn-sm btn-icon-text button-add-purple uk-margin-small-left">
                        <i class="mdi mdi-filter btn-icon-prepend"></i>
                            <?= ucwords($this->request->getParam('filter')) ?>
                    </button>
                    <div uk-dropdown="pos: bottom-right; mode: click">
                        <ul class="uk-nav uk-dropdown-nav text-right">
                            <li class=""><a href="<?= $this->Url->build(['_name' => $routePrefix . 'Vendors']) ?>">All Vendors</a></li>
                            <li class="uk-nav-divider"></li>
                            <li class="<?php if ($this->request->getParam('filter') == 'unverified') echo 'uk-active' ?>"><a href="<?= $filterUnverifiedUrl ?>">Unverified (<?= $unverified; ?>)</a></li>
                            <li class="<?php if ($this->request->getParam('filter') == 'verified') echo 'uk-active' ?>"><a href="<?= $filterVerifiedUrl ?>">Verified (<?= $verified; ?>)</a></li>
                            <li class="<?php if ($this->request->getParam('filter') == 'banned') echo 'uk-active' ?>"><a href="<?= $filterBannedUrl ?>">Banned (<?= $banned; ?>)</a></li>
                            <li class="<?php if ($this->request->getParam('filter') == 'active') echo 'uk-active' ?>"><a href="<?= $filterActiveUrl ?>">Active (<?= $active; ?>)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body <?php if ($vendors->count() == 0) echo 'uk-padding-remove' ?>">
                <?php
                    if ($vendors->count() > 0):
                ?>
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-justify uk-table-divider uk-table-middle purple-datatable purple-smaller-table">
                        <thead>
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Phone
                                </th>
                                <th>
                                    Location
                                </th>
                                <th width="120">
                                    Registered
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
                                foreach ($vendors as $vendor): 
                                    $viewUrl = $this->Url->build([
                                        '_name'  => $routePrefix . 'VendorViewDetail',
                                        'id'     => $vendor->id,
                                    ]);

                                    $province = $this->cell('Bridestiny.Vendors::getProvinceName', [$vendor->province]);
                                    $city     = $this->cell('Bridestiny.Vendors::getCityName', [$vendor->city]);
                            ?>
                            <tr>
                                <td>
                                    <?= $vendor->name ?>
                                </td>
                                <td>
                                    <a href="mailto:<?= $vendor->email ?>"><?= $vendor->email ?></a>
                                </td>
                                <td>
                                <a href="tel:<?= $vendor->mobile_phone ?>"><?= $vendor->mobile_phone ?></a>
                                </td>
                                <td>
                                    <?= $city ?> - <?= $province ?>
                                </td>
                                <td>
                                    <span data-livestamp="<?= $vendor->created ?>"></span>
                                </td>
                                <td>
                                    <?= $vendor->text_status ?>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-gradient-primary btn-rounded btn-icon" uk-tooltip="View Vendor" onclick="location.href='<?= $viewUrl; ?>'">
                                        <i class="mdi mdi-book-open"></i>
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
                <div class="uk-alert-danger <?php if ($vendors->count() == 0) echo 'uk-margin-remove-bottom' ?>" uk-alert>
                    <p>Can't find <?= $this->request->getParam('filter') ?> vendor.</p>
                </div>
                <?php
                    endif;
                ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
    	<?php
            if ($vendors->count() > 0):
        ?>
        var dataTable = $('.purple-datatable').DataTable({
            "order": [],
            responsive: true,
            "columnDefs": [{
                "targets": -1,
                "orderable": false
            }]
        });
        <?php
            endif;
        ?>
    })
</script>