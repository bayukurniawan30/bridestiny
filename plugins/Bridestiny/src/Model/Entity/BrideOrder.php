<?php

namespace Bridestiny\Model\Entity;

use Cake\ORM\Entity;
use Cake\Http\ServerRequest;
use Bridestiny\Functions\GlobalFunctions;

class BrideOrder extends Entity
{
	protected $_accessible = [
		'*' => true,
		'id' => false,
	];
    protected function _getTextStatus()
    {
        if ($this->status == '1') {
            return 'Paid';
        }
        elseif ($this->status == '2') {
            return 'Down Payment';
        }
        elseif ($this->status == '0') {
            return 'New';
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