<?php

namespace Bridestiny\Model\Entity;

use Cake\ORM\Entity;
use Cake\Http\ServerRequest;
use Bridestiny\Functions\GlobalFunctions;

class BrideAdsPayment extends Entity
{
	protected $_accessible = [
		'*' => true,
		'id' => false,
	];
    protected function _getTextStatus()
    {
        if ($this->status == '0') {
            return 'Pending';
        }
        elseif ($this->status == '1') {
            return 'Received';
        }
        elseif ($this->status == '2') {
            return 'Expired';
        }
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
}