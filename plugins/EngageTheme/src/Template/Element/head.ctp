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
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lobster+Two|Old+Standard+TT" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Font Awesome 4.7 -->
    <?= $this->Html->css('font-awesome.min.css') ?>

    <!-- Bootstrap -->
    <?= $this->Html->css('bootstrap.min.css') ?>
    <!-- Template CSS -->
    <?= $this->Html->css('libs/slick.css') ?>
    <?= $this->Html->css('libs/slick-theme.css') ?>
    <?= $this->Html->css('libs/aos.css') ?>
    <?= $this->Html->css('/plugins/select2/css/select2.min.css') ?>
    <!-- Froala Blocks -->
    <?= $this->Html->css('/master-assets/plugins/froala-blocks/css/froala_blocks.css') ?>
    <!-- UI Kit -->
    <?= $this->Html->css('/master-assets/plugins/uikit/css/uikit.css') ?>
    <!-- Parsley -->
    <?= $this->Html->css('/master-assets/plugins/parsley/src/parsley.css') ?>
    <!-- Bttn -->
    <?= $this->Html->css('/master-assets/css/bttn.css') ?>
    <!-- Template CSS -->
    <?= $this->Html->css('global.css') ?>
    <?= $this->Html->css('header-hero.css') ?>
    <?= $this->Html->css('costum.css') ?>

    <?php if ($favicon != ''): ?>
    <!-- Favicon -->
    <link rel="icon" href="<?= $this->request->getAttribute("webroot").'uploads/images/original/' . $favicon ?>">
    <?php else: ?>
    <!-- Favicon -->
    <link rel="icon" href="<?= $this->request->getAttribute("webroot").'master-assets/img/favicon.png' ?>">
    <?php endif; ?>

    <!-- jQuery -->
    <?= $this->Html->script('https://code.jquery.com/jquery-3.4.1.min.js', ['integrity' => 'sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=', 'crossorigin' => 'anonymous']); ?>
    <?= $this->Html->script('https://code.jquery.com/ui/1.12.1/jquery-ui.js'); ?>

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