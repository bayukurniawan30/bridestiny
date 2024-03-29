<?php

namespace Bridestiny\Model\Entity;

use Cake\ORM\Entity;
use Cake\Core\Configure;
use Cake\Http\ServerRequest;
use Bridestiny\Functions\GlobalFunctions;

class BrideVendor extends Entity
{
	protected $_accessible = [
		'*' => true,
		'id' => false,
    ];
    protected function _getFullName()
    {
        return ucwords($this->name);
    }
    protected function _getBrideType()
    {
        return 'Vendor';
    }
    protected function _getMobilePhone()
    {
        return '+' . $this->calling_code . $this->phone;
    }
    protected function _getProvinceName()
    {
        Configure::load('Bridestiny.purple');

        $rajaongkirApiKey  = Configure::read('RajaOngkir.apikey');
        $rajaongkirAccType = Configure::read('RajaOngkir.account');

        $globalFunction     = new GlobalFunctions();
        $rajaongkirProvince = $globalFunction->rajaongkirProvinceDetail($rajaongkirApiKey, $rajaongkirAccType, $this->province);
        return $rajaongkirProvince['province'];

    }
    protected function _getCityName()
    {
        Configure::load('Bridestiny.purple');

        $rajaongkirApiKey  = Configure::read('RajaOngkir.apikey');
        $rajaongkirAccType = Configure::read('RajaOngkir.account');

        $globalFunction = new GlobalFunctions();
        $rajaongkirCity = $globalFunction->rajaongkirCityDetail($rajaongkirApiKey, $rajaongkirAccType, $this->city);
        return $rajaongkirCity['city_name'];
    }
    protected function _getCreated($created)
    {
        $serverRequest   = new ServerRequest();
        $session         = $serverRequest->getSession();
        $timezone        = $session->read('Purple.timezone');
        $settingTimezone = $session->read('Purple.settingTimezone');

        $date = new \DateTime($created, new \DateTimeZone($settingTimezone));
        $date->setTimezone(new \DateTimeZone($timezone));
        return $date->format('Y-m-d H:i:s');
    }
    protected function _getModified($modified)
    {
        if ($modified == NULL) {
            return $modified;
        }
        else {
            $serverRequest   = new ServerRequest();
            $session         = $serverRequest->getSession();
            $timezone        = $session->read('Purple.timezone');
            $settingTimezone = $session->read('Purple.settingTimezone');

            $date = new \DateTime($modified, new \DateTimeZone($settingTimezone));
            $date->setTimezone(new \DateTimeZone($timezone));
            return $date->format('Y-m-d H:i:s');
        }
    }
}