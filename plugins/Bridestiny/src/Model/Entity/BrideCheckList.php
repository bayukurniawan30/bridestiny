<?php

namespace Bridestiny\Model\Entity;

use Cake\ORM\Entity;
use Cake\Http\ServerRequest;
use Bridestiny\Functions\GlobalFunctions;

class BrideCheckList extends Entity
{
	protected $_accessible = [
		'*' => true,
		'id' => false,
	];
    protected function _getTextStatus()
    {
        if ($this->status == '1') {
            return 'Listed';
        }
        elseif ($this->status == '2') {
            return 'Checked';
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