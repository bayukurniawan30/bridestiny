<head>
    <?= $this->Html->charset(); ?>
    <title><?= $this->element('head_title') ?></title>
    <?php 
        // Meta Viewport
        echo $this->Html->meta(
            'viewport',
            'width=device-width, initial-scale=1'
        );

        // Meta Author
        echo $this->Html->meta(
            'author',
            $siteName
        );

        // Meta Keywords
        echo $this->Html->meta(
            'keywords',
            $metaKeywords
        );

        // Meta Description
        echo $this->Html->meta(
            'description',
            $metaDescription
        );
        
        // Meta Open Graph
        echo $this->element('Meta/open_graph');

        // Meta Twitter
        echo $this->element('Meta/twitter') 
    ?>

    <link rel="canonical" href="<?= $this->Url->build($this->request->getRequestTarget(), true) ?>">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,700,900|Display+Playfair:200,300,400,700"> 
    <?= $this->Html->css('/credintial/css/bootstrap.min.css') ?>
    <?= $this->Html->css('/credintial/css/nanoscroller.css') ?>
    <?= $this->Html->css('/credintial/fonts/icomoon/style.css') ?>

    <!-- UI Kit -->
    <?= $this->Html->css('/master-assets/plugins/uikit/css/uikit.css') ?>
    <!-- Parsley -->
    <?= $this->Html->css('/master-assets/plugins/parsley/src/parsley.css') ?>

    <?= $this->Html->css('/credintial/css/style.css') ?>

    <?php if ($favicon != ''): ?>
    <!-- Favicon -->
    <link rel="icon" href="<?= $this->request->getAttribute("webroot").'uploads/images/original/' . $favicon ?>">
    <?php else: ?>
    <!-- Favicon -->
    <link rel="icon" href="<?= $this->request->getAttribute("webroot").'master-assets/img/favicon.png' ?>">
    <?php endif; ?>


    <?php if ($formSecurity == 'on'): ?>
    <!-- Google reCaptcha -->
    <?= $this->Html->script('https://www.google.com/recaptcha/api.js?render='.$recaptchaSitekey); ?>
    <?php endif; ?>

    <!-- Schema.org ld+json -->
    <?php
        if ($this->request->getParam('action') == 'home') {
            echo html_entity_decode($ldJsonWebsite);
            echo html_entity_decode($ldJsonOrganization);
        }

        // WebPage
        if (isset($webpageSchema)) {
            echo html_entity_decode($webpageSchema);
        }
        
        // BreadcrumbList
        if (isset($breadcrumbSchema)) {
            echo html_entity_decode($breadcrumbSchema);
        }

        // Article
        if (isset($articleSchema)) {
            echo html_entity_decode($articleSchema);
        }
    ?>

    <?= $this->Html->script('/credintial/js/jquery-3.3.1.slim.min.js'); ?>

    <!-- Bridestiny Plugin -->
    <?= $this->Html->css('Bridestiny./plugins/intl-tel-input/css/intlTelInput.min.css') ?>
    <?= $this->Html->script('Bridestiny.front.js'); ?>

    <!-- Purple Timezone -->
    <?= $this->Html->script('/master-assets/plugins/moment/moment.js'); ?>
    <?= $this->Html->script('/master-assets/plugins/moment-timezone/moment-timezone.js'); ?>
    <?= $this->Html->script('/master-assets/plugins/moment-timezone/moment-timezone-with-data.js'); ?>
    <?= $this->Html->script('/master-assets/js/purple-timezone.js'); ?>
    <script type="text/javascript">
        $(document).ready(function(){
            clientTimezone('<?= $timeZone ?>');
        })
    </script>

    <script type="text/javascript">
        var cakeDebug    = "<?= $cakeDebug ?>",
            formSecurity = "<?= $formSecurity ?>";
        window.cakeDebug    = cakeDebug;
        window.formSecurity = formSecurity;
    </script>
</head>