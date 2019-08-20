<li class="nav-item <?php if ($this->request->getParam('plugin') == 'Bridestiny') echo 'active'; ?>">
    <a class="nav-link" data-toggle="collapse" href="#purple-plugin-bridestiny" aria-expanded="<?php if ($this->request->getParam('plugin') == 'Bridestiny') echo 'true'; else echo 'false' ?>" aria-controls="purple-plugin-bridestiny">
        <span class="menu-title">Bridestiny</span>
        <i class="menu-arrow"></i>
        <i class="mdi mdi-ring mdi-rotate-45 menu-icon"></i>
    </a>
    <div class="collapse <?php if ($this->request->getParam('plugin') == 'Bridestiny') echo 'show'; ?>" id="purple-plugin-bridestiny">
        <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="">Overview</a></li>
            <li class="nav-item"> <a class="nav-link <?php if ($this->request->getParam('plugin') == 'Bridestiny' && $this->request->getParam('controller') == 'Customers') echo 'active'; ?>" href="<?= $this->Url->build(["_name" => $routePrefix . "Customers"]); ?>">Customers</a></li>
            <li class="nav-item"> <a class="nav-link <?php if ($this->request->getParam('plugin') == 'Bridestiny' && $this->request->getParam('controller') == 'Categories') echo 'active'; ?>" href="<?= $this->Url->build(["_name" => $routePrefix . "Categories"]); ?>">Categories</a></li>
            <li class="nav-item"> <a class="nav-link <?php if ($this->request->getParam('plugin') == 'Bridestiny' && $this->request->getParam('controller') == 'Currencies') echo 'active'; ?>" href="<?= $this->Url->build(["_name" => $routePrefix . "Currencies"]); ?>">Currencies</a></li>
            <li class="nav-item"> <a class="nav-link <?php if ($this->request->getParam('plugin') == 'Bridestiny' && $this->request->getParam('controller') == 'Settings') echo 'active'; ?>" href="<?= $this->Url->build(["_name" => $routePrefix . "Settings"]); ?>">Settings</a></li>
        </ul>
    </div>
</li>