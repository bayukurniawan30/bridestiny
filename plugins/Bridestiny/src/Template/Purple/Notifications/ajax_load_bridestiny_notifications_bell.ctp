<?php
    if ($unread > 0):
?>
<i class="fa fa-bell text-danger" uk-tooltip="title: You have <?= strtolower($this->Purple->plural($unread, 'notification', 's', true)) ?>"></i>

<script type="text/javascript">
    $(document).ready(function() {
        $('.bridestiny-sidebar-notification-circle').show();
    })
</script>
<?php
    else:
?>
<i class="fa fa-bell-o" uk-tooltip="title: There is no notification"></i>

<script type="text/javascript">
    $(document).ready(function() {
        $('.bridestiny-sidebar-notification-circle').hide();
    })
</script>
<?php
    endif;
?>