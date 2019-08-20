<?php

namespace Bridestiny\View\Cell;

use Cake\View\Cell;
use Cake\Http\ServerRequest;
use Cake\Log\Log;
use Bridestiny\Functions\GlobalFunctions;

class CurrenciesCell extends Cell
{
    private function routePrefix()
    {
        // Plugin Function
        $globalFunction = new GlobalFunctions();
        $routePrefix    = $globalFunction->routePrefix();
        return $routePrefix;
    }
    public function convert($from, $to, $value, $format = false)
    {
        // Plugin Function
        $globalFunction    = new GlobalFunctions();
        if ($to == 'IDR') {
            $currencyConverter = $globalFunction->currencyConverterCache($from);
            $result = $currencyConverter * $value;
        }
        else {
            $currencyConverter = $globalFunction->currencyConverterCache($to);
            $result = round($value / $currencyConverter, 2);
        }

        if ($format == false) {
            $this->set('result', $result);
        }
        else {
            if ($to == 'IDR') {
                $formatted = $globalFunction->formatRupiah($result);
                $this->set('result', $formatted);
            }
            else {
                $currencySymbol = $globalFunction->currencySymbol($to);
                $this->set('result', $currencySymbol . $result);
            }
        }
    }
}