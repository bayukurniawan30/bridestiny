<?php
    if ($relation == 'Vendors') {
        $targetUrl = $this->Url->build([
            '_name' => $routePrefix . 'VendorViewDetail',
            'id'    => $target->id,
        ]);
    }
    elseif ($relation == 'Customers') {
        $targetUrl = $this->Url->build([
            '_name' => $routePrefix . 'CustomerViewDetail',
            'id'    => $target->id,
        ]);
    }

?>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div id="page-detail-card" class="card">
            <div class="card-header">
                <h4 class="card-title uk-margin-remove-bottom">Notification Detail</h4>
            </div>
            <div class="card-toolbar">
            	<button type="button" class="btn btn-gradient-primary btn-toolbar-card btn-sm btn-icon-text" onclick="location.href='<?= $targetUrl ?>'">
                <i class="mdi mdi-link-variant btn-icon-prepend"></i>
                	Go To <?= $notification->link_from_type ?>
                </button>
            </div>
            <div class="card-body" onclick="location.href='<?= $targetUrl ?>'" style="cursor: pointer">
            	<ul class="uk-comment-list">
            		<li>
				        <article class="uk-comment uk-visible-toggle">
				            <header class="uk-comment-header uk-position-relative">
				                <div class="uk-flex-middle">
				                    <div class="">
				                        <h4 class="uk-comment-title uk-margin-remove"><?= $notification->title_from_type ?></h4>
				                        <p class="uk-comment-meta uk-margin-remove-top uk-margin-remove-bottom">
                                            <i class="fa fa-clock-o"></i> <span class="uk-link-reset" href="#" data-livestamp="<?= $notification->created ?>"></span><span class="fdb-button-option-divider uk-margin-small-left uk-margin-small-right">|</span> <i class="fa fa-globe"></i> <?= $notification->text_status ?>
                                        </p>
				                    </div>
				                </div>
				            </header>
				            <div class="uk-comment-body">
				                <p><?= $notification->content ?></p>
				            </div>
				        </article>
                    </li>
            	</ul>
            </div>
        </div>
    </div>
</div>