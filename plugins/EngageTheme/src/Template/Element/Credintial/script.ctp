<?= $this->Html->script('/credintial/js/bootstrap.min.js'); ?>
<?= $this->Html->script('/credintial/js/jquery.nanoscroller.min.js'); ?>
<?= $this->Html->script('/credintial/js/custom.js'); ?>

<!-- UI Kit -->
<?= $this->Html->script('/master-assets/plugins/uikit/js/uikit.js'); ?>
<?= $this->Html->script('/master-assets/plugins/uikit/js/uikit-icons.js'); ?>
<!-- Parsley -->
<?= $this->Html->script('/master-assets/plugins/parsley/dist/parsley.js'); ?>
<!-- Purple -->
<?= $this->Html->script('/master-assets/js/ajax-front-end.js'); ?>

<script type="text/javascript">
	$(document).ready(function(){
        $(".nano").nanoScroller();
    })
</script>