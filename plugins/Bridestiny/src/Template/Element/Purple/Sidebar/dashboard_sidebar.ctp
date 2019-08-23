<li class="nav-item <?php if ($this->request->getParam('plugin') == 'Bridestiny') echo 'active'; ?>">
    <a class="nav-link" data-toggle="collapse" href="#purple-plugin-bridestiny" aria-expanded="<?php if ($this->request->getParam('plugin') == 'Bridestiny') echo 'true'; else echo 'false' ?>" aria-controls="purple-plugin-bridestiny">
        <span class="menu-title">Bridestiny <span class="bridestiny-sidebar-notification-circle" style="display: none"></span></span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-ring mdi-rotate-45 menu-icon"></i>
    </a>
    <div class="collapse <?php if ($this->request->getParam('plugin') == 'Bridestiny') echo 'show'; ?>" id="purple-plugin-bridestiny">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link <?php if ($this->request->getParam('plugin') == 'Bridestiny' && $this->request->getParam('controller') == 'Notifications') echo 'active'; ?>" href="<?= $this->Url->build(["_name" => $routePrefix . "Notifications"]); ?>">Notifications <span id="bridestiny-notification-bell" class="" style="position: absolute; right: 0; color: #bba8bff5"><i class="fa fa-bell-o"></i></span></a></li>

            <li class="nav-item"> <a class="nav-link" href="">Overview</a></li>

            <li class="nav-item"> <a class="nav-link <?php if ($this->request->getParam('plugin') == 'Bridestiny' && $this->request->getParam('controller') == 'Customers') echo 'active'; ?>" href="<?= $this->Url->build(["_name" => $routePrefix . "Customers"]); ?>">Customers</a></li>

            <li class="nav-item"> <a class="nav-link <?php if ($this->request->getParam('plugin') == 'Bridestiny' && $this->request->getParam('controller') == 'Vendors') echo 'active'; ?>" href="<?= $this->Url->build(["_name" => $routePrefix . "Vendors"]); ?>">Vendors</a></li>

            <li class="nav-item"> <a class="nav-link <?php if ($this->request->getParam('plugin') == 'Bridestiny' && $this->request->getParam('controller') == 'Categories') echo 'active'; ?>" href="<?= $this->Url->build(["_name" => $routePrefix . "Categories"]); ?>">Categories</a></li>

            <li class="nav-item"> <a class="nav-link <?php if ($this->request->getParam('plugin') == 'Bridestiny' && $this->request->getParam('controller') == 'Currencies') echo 'active'; ?>" href="<?= $this->Url->build(["_name" => $routePrefix . "Currencies"]); ?>">Currencies</a></li>

            <li class="nav-item"> <a class="nav-link <?php if ($this->request->getParam('plugin') == 'Bridestiny' && $this->request->getParam('controller') == 'Settings') echo 'active'; ?>" href="<?= $this->Url->build(["_name" => $routePrefix . "Settings"]); ?>">Settings</a></li>
        </ul>
    </div>
</li>

<script type="text/javascript">
    $(document).ready(function() {
        $('.bridestiny-sidebar-notification-circle').hide();
        
        setTimeout(function() {
			$("#bridestiny-notification-bell").load('<?= $this->Url->build(['_name' => $routePrefix . 'NotificationsAction', 'action' => 'ajaxLoadBridestinyNotificationsBell']) ?>');
        }, 3000);

		function loadNotificationsAndMessagesCounter(){
			$("#bridestiny-notification-bell").load('<?= $this->Url->build(['_name' => $routePrefix .  'NotificationsAction', 'action' => 'ajaxLoadBridestinyNotificationsBell']) ?>');
		}
		setInterval(function(){loadNotificationsAndMessagesCounter()}, 180000);
    })
</script>