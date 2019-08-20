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
		<?= $this->element('Modals/login') ?>

		<?= $this->element('script') ?>
  	</body>
</html>