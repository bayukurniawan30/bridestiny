<?php
namespace Bridestiny\View\Helper;

use Cake\View\Helper;

class BrideHelper extends Helper
{
    public function categoryIconConverter($icon, $size, $color)
    {
        $icon = str_replace('{{pixelSize}}', $size, $icon);
        $icon = str_replace('{{color}}', $color, $icon);

        return $icon;
    }
}