<?php

namespace Bridestiny\View\Cell;

use Cake\View\Cell;
use Cake\Core\Configure;
use Bridestiny\Functions\GlobalFunctions;

class VendorsCell extends Cell
{
    public function getProvinceName($id)
    {
        Configure::load('Bridestiny.purple');

        $rajaongkirApiKey  = Configure::read('RajaOngkir.apikey');
        $rajaongkirAccType = Configure::read('RajaOngkir.account');

        $globalFunction     = new GlobalFunctions();
        $rajaongkirProvince = $globalFunction->rajaongkirProvinceDetail($rajaongkirApiKey, $rajaongkirAccType, $id);

        $this->set('province', json_encode($rajaongkirProvince));
    }
    public function getCityName($id)
    {
        Configure::load('Bridestiny.purple');

        $rajaongkirApiKey  = Configure::read('RajaOngkir.apikey');
        $rajaongkirAccType = Configure::read('RajaOngkir.account');

        $globalFunction = new GlobalFunctions();
        $rajaongkirCity = $globalFunction->rajaongkirCityDetail($rajaongkirApiKey, $rajaongkirAccType, $id);

        $this->set('city', json_encode($rajaongkirCity));
    }
}