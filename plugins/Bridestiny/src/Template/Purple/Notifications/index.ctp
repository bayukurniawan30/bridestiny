<?php
    if ($notifications->count() > 0) {
        $filterAllUrl = $this->Url->build([
            '_name'  => $routePrefix . 'Notifications'
        ]);
        $filterReadUrl = $this->Url->build([
            '_name'  => $routePrefix . 'NotificationFilter',
            'filter' => 'read',
        ]);
        $filterUnreadUrl = $this->Url->build([
            '_name'  => $routePrefix . 'NotificationFilter',
            'filter' => 'unread',
        ]);
    }
?>
<div class="row">
    <div class="col-md-12">
        <!-- Messages -->
        <?php
            if ($unread > 0):
        ?>
        <div class="uk-alert-warning" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p><span uk-icon="warning"></span> You have <strong><?= $unread ?> unread</strong> notification(s).</p>
        </div>
        <?php
            endif;
        ?>
    </div>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title uk-margin-remove-bottom">Notifications</h4>
            </div>
            <?php
                if ($notifications->count() > 0):
            ?>
            <div class="card-toolbar">
                <button type="button" class="btn btn-gradient-primary btn-toolbar-card btn-sm btn-icon-text active" onclick="location.href='<?= $filterAllUrl ?>'">
                <i class="mdi mdi-bell btn-icon-prepend"></i>
                    All
                </button>
                <button type="button" class="btn btn-gradient-primary btn-toolbar-card btn-sm btn-icon-text uk-margin-small-left" onclick="location.href='<?= $filterReadUrl ?>'">
                <i class="mdi mdi-email-open btn-icon-prepend"></i>
                    Read
                </button>
                <button type="button" class="btn btn-gradient-primary btn-toolbar-card btn-sm btn-icon-text uk-margin-small-left" onclick="location.href='<?= $filterUnreadUrl ?>'">
                <i class="mdi mdi-email btn-icon-prepend"></i>
                    Unread
                </button>
            </div>
            <?php endif; ?>
            <div class="card-body <?php if ($notifications->count() == 0) echo 'uk-padding-remove' ?>">
                <?php
                    if ($notifications->count() > 0):
                ?>
                <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-justify uk-table-divider uk-table-middle purple-datatable purple-smaller-table">
                        <thead>
                            <tr>
                                <th>
                                    Message
                                </th>
                                <th width="120">
                                    Date
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
                                foreach ($notifications as $notification): 
                                    $viewUrl = $this->Url->build([
                                        '_name'  => $routePrefix . 'NotificationDetail',
                                        'id'     => $notification->id,
                                    ]);
                            ?>
                            <tr>
                                <td>
                                    <?php
                                        if ($notification->is_read == '1'):
                                    ?>
                                    <i class="mdi mdi-read uk-margin-small-right"></i> 
                                    <?php
                                        endif;

                                        echo $this->Text->truncate(
                                            $notification->content,
                                            80,
                                            [
                                                'ellipsis' => ' ...',
                                                'exact' => false
                                            ]);
                                    ?>
                                </td>
                                <td>
                                    <span data-livestamp="<?= $notification->created ?>"></span>
                                </td>
                                <td>
                                    <?= $notification->text_status ?>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-gradient-primary btn-rounded btn-icon" uk-tooltip="View Notification" onclick="location.href='<?= $viewUrl; ?>'">
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
                <div class="uk-alert-danger <?php if ($notifications->count() == 0) echo 'uk-margin-remove-bottom' ?>" uk-alert>
                    <p>Can't find notification.</p>
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
            if ($notifications->count() > 0):
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