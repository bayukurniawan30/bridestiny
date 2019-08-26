<section class="fullscreen-slideshowS relative mt-0 paroller" data-paroller-factor="-0.2">
    <div class="fullscreen-slideshow-content">
        <div class="item"> 
            <div class="detail-page text-center">
                <h3 class="text-black non-uikit text-uppercase lt-2 bridestiny-page-title"><?= $pageTitle ?></h3>
                <div class="bridestiny-page-title-divider"></div>
            </div>
        </div>
    </div>
</section>

<?= $this->element('breadcrumb', [
    'breadcrumb' => $breadcrumb
]) ?>


<?php
    $replaceFunction = $this->Purple->getAllFuncInHtml(html_entity_decode($viewPage->general->content));
    if ($replaceFunction == false) {
        echo html_entity_decode($viewPage->general->content);
    }
    else {
        $i = 1;
        foreach ($replaceFunction as $data):
            $functionName = trim(str_replace('function|', '', $data));
            if ($i == 1) {
                $html = str_replace('{{function|'.$functionName.'}}', $themeFunction->$functionName(), html_entity_decode($viewPage->general->content));
            }
            else {
                $html = str_replace('{{function|'.$functionName.'}}', $themeFunction->$functionName(), $html);
            }
            $i++;
        endforeach;

        echo $html;
    }
?>