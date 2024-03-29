<!-- DOCTYPE -->
<?= $this->Html->docType(); ?>
<html lang="en">
	<?= $this->element('head') ?>
  	<body class="normal">
	  	<!--CSRF Token-->
		<input id="csrf-ajax-token" type="hidden" name="token" value=<?= json_encode($this->request->getParam('_csrfToken')); ?>>
  		<!-- Client Timezone -->
		<input id="client-timezone-url" type="hidden" name="clientTimezoneUrl" value="<?= $this->Url->build(['_name' => 'setClientTimezone']); ?>">

		<?= $this->element('Header/navigation') ?>

		<div class="page-container">
			<!-- Fetch Content -->
			<?= $this->fetch('content') ?>

			<?= $this->element('Footer/footer') ?>
		</div>

		<!-- Modals -->
		<?php 
			if ($userData == NULL):
		?>
		<?= $this->element('Modals/couples_login') ?>
		<?= $this->element('Modals/vendor_login') ?>
		<?php
			endif;
		?>

		<?= $this->element('script') ?>
  	</body>
</html>