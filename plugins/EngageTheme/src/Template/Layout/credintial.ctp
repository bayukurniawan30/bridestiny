<!-- DOCTYPE -->
<?= $this->Html->docType(); ?>
<html lang="en">
    <?= $this->element('Credintial/head') ?>

    <body>
        <!--CSRF Token-->
		<input id="csrf-ajax-token" type="hidden" name="token" value=<?= json_encode($this->request->getParam('_csrfToken')); ?>>
  		<!-- Client Timezone -->
        <input id="client-timezone-url" type="hidden" name="clientTimezoneUrl" value="<?= $this->Url->build(['_name' => 'setClientTimezone']); ?>">
        
        <div class="d-flex">
            <div class="form-wrap d-flex">
                <div class="" style="width: 100%">
                    <div class="form-wrap-inner align-self-center h-100">
                        <a href="<?= $this->Url->build(['_name' => 'home']); ?>" class="logo">
                            <?php
                                if ($logo == ''):
                                    echo $this->Html->image('logo.svg', ['alt' => '', 'class' => 'main-logo']);
                                else:
                                    echo '<img src="'.$this->request->getAttribute("webroot").'uploads/images/original/' . $logo.'" alt="'.$siteName.'">';
                                endif; 
                            ?>
                        </a>

                        <?= $this->fetch('content') ?>

                        </div>
                    </div>
                </div>
            <div class="img-wrap" style="background-image: url('<?= $this->Url->image('slideshow/s1.jpg'); ?>');">
        </div>
    </div>

    <?= $this->element('Credintial/script') ?>
</html>