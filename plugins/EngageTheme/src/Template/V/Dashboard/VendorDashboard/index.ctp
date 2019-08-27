<?= $this->element('V/Dashboard/dashboard_title') ?>

<?= $this->element('breadcrumb', [
    'breadcrumb' => $breadcrumb
]) ?>

<?= $this->element('V/Dashboard/dashboard_navigation') ?>

<section class="register-form bg-white mt-0" style="padding-top: 50px;">
    <div class="container">
        <div class="row">

            <?= $this->element('V/Dashboard/dashboard_stats') ?>
            
            <div class="col-md-12 uk-margin-top">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Orders</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            No.
                                        </th>
                                        <th>
                                            Customer Name
                                        </th>
                                        <th>
                                            Order Date
                                        </th>
                                        <th>
                                            Due Date
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1.</td>
                                        <td>
                                            David Grey
                                        </td>
                                        <td>29 January 2019</td>
                                        <td>30 july 2019</td>
                                        <td><label class="badge badge-gradient-info">Pending</label></td>
                                    </tr>
                                    <tr>
                                        <td>2.</td>
                                        <td>
                                            David Grey Scale
                                        </td>
                                        <td>29 January 2019</td>
                                        <td>19 july 2019</td>
                                        <td><label class="badge badge-gradient-success">Payment</label></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <br>
        </div>
        <div class="clear"></div>
        <br>
    </div>
</section>