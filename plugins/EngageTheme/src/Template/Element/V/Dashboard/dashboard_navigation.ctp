<?php
    $dashboardUrl = $this->Url->build([
        '_name'  => $themeFunction->routePrefix() . 'VendorDashboard'
    ]);

    $profileUrl = $this->Url->build([
        '_name'  => $themeFunction->routePrefix() . 'VendorDashboardAction',
        'action' => 'profile'
    ]);
?>

<section class="menu-admin mt-0 p-0 mb-0">
    <div class="container">
        <div class="">
            <ul class="d-flex justify-content-center">
                <li class="<?php if ($this->request->getParam('action') == 'index') echo 'active' ?>"><a href="<?= $dashboardUrl ?>"><i class="fa fa-dashboard db-icon"></i> Dashboard</a></li>
                <li class="<?php if ($this->request->getParam('action') == 'profile') echo 'active' ?>"><a href="<?= $profileUrl ?>"><i class="fa fa-user db-icon"></i> Profile</a> </li>
                <li class="<?php if ($this->request->getParam('action') == 'packages') echo 'active' ?>"><a href="#"><i class="fa fa-list db-icon"></i> Packages</a> </li>
                <li class="<?php if ($this->request->getParam('action') == 'projects') echo 'active' ?>"><a href="#" ><i class="fa fa-th-large db-icon"></i> Projects</a> </li>
                <li class="<?php if ($this->request->getParam('action') == 'faqs') echo 'active' ?>"><a href="#"><i class="fa fa-question-circle-o db-icon" aria-hidden="true"></i> FAQs</a> </li>
                <li class="<?php if ($this->request->getParam('action') == 'orders') echo 'active' ?>"><a href="#"><i class="fa fa-file-text-o db-icon" aria-hidden="true"></i> Orders</a> </li>
                <li class="<?php if ($this->request->getParam('action') == 'wallet') echo 'active' ?>"><a href="#"><i class="fa fa-money db-icon" aria-hidden="true"></i> Wallet</a> </li>
            </ul>
        </div>
    </div>
</section>